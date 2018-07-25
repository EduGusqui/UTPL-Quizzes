import { Component, OnInit, AfterViewInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { UserService } from '../../services/user.service';
import { User } from '../../model/user';
import { ModalService } from '../../services/modal.service';

@Component({
	templateUrl: 'list.component.html'
})

export class UserListComponent implements OnInit, AfterViewInit {
	
	errorMessage: string;
	users: User[];
	showPopUp: boolean;
	idUser: number;
	title: string;
	description: string;
	accept: string;
	cancel: string;
	showButton: boolean;
	
	constructor(private route: ActivatedRoute, private userService: UserService, 
		private modalService: ModalService) {}

	ngOnInit(): void {
		this.userService.GetAll().subscribe(users => {
			this.users = users;
		}), error => {
			this.errorMessage = <any>error;
		}
	}

	ngAfterViewInit(): void {
		this.closeModal('modal');
	}

	delete(modalName: string, idUser: number): void {
		this.showButton = true;
		this.idUser = idUser;
		this.title = "Eliminar";
		this.description = "¿Está seguro de eliminar el usuario?"
		this.openModal(modalName, idUser)
	}

	deleteUser():void {
		this.userService.deleteUser(this.idUser).subscribe(() => {
			this.userService.GetAll().subscribe(users => {
				this.users = users;
				this.showButton = false;
				this.title = "Eliminado";
				this.description = "El usuario ha sido eliminado!"
			}), error => {
				this.errorMessage = <any>error;
				this.title = "Error";
				this.description = "Ocurrió un error cargar los usuarios";
			}
		}), error => {
			this.errorMessage = <any>error;
			this.title = "Error";
			this.description = "Ocurrió un error al eliminar el usuario";
		}
		
	}

	openModal(modalName: string, idUser: number) {
		this.modalService.open('modal');
	}

	closeModal(modalName: string) {
		this.modalService.close(modalName);
	}
}