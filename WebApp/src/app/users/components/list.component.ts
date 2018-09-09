import { Component, OnInit, ViewChild } from '@angular/core';
import { User } from '../models/user';
import { UserService } from '../services/user.service';
import { DataTableDirective } from 'angular-datatables';
import { Subject } from 'rxjs';
import { AuthService } from '../../security/auth.service';
import swal from 'sweetalert2';

@Component({
	templateUrl: 'list.component.html'
})

export class UserListComponent implements OnInit {

	@ViewChild(DataTableDirective)
	dtElement: DataTableDirective;
	errorMessage: string;
	users: User[];
	dtOptions: any = {};
	dtTrigger: Subject<string> = new Subject();
	
	constructor(private userService: UserService, private authService: AuthService) { }
	
	ngOnInit(): void {
		this.dtOptions = {
			pagingType: 'numbers',
			pageLength: 5,
			searching: true,
			lengthChange: true,
			lengthMenu: [5,10,25,50],
			responsive: true,
			language: {
				zeroRecords: "No se han encontrado registros",
				paginate: {
				first: "Inicio",
				last: "Fin",
				next: "Siguiente",
				previous: "Anterior"
				},
				info: "Mostrando _START_ al _END_ de _TOTAL_ registros",
				infoEmpty: "Mostrando 0 al 0 de 0 registros",
				infoFiltered: "(filtrados de _MAX_ registros en total)",
				search: "Buscar:",
				lengthMenu: "Mostrar _MENU_ registros"
			},
			columnDefs: [{
				targets: 'no-sort',
				orderable: false
			}],
		}

		this.userService.getAll().subscribe(users => {
			this.users = users;
			this.dtTrigger.next();
		}), error => {
			this.authService.showError("Ocurrió un error al cargar los usuarios: " + error);
		}
	}

	ngOnDestroy(): void {
    	this.dtTrigger.unsubscribe();
	}

	delete(idUser: number) {
		swal({
			title: '¿Está seguro?',
			text: 'Va a eliminar este usuario!',
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#0266b1',
			confirmButtonText: 'Si, eliminelo'
		}).then((result) => {
			if(result.value) {
				this.userService.delete(idUser).subscribe(() => {
					this.userService.getAll().subscribe(users => {
						this.users = users;
						this.rerender();
						this.authService.showSuccess("Usuario eliminado con éxito.");
					}), error => {
						this.errorMessage = <any>error;
						this.authService.showError("Ocurrió un error al cargar los usuarios");
					}
				}), error => {
					this.errorMessage = <any>error;
					this.authService.showError("Ocurrió un error al eliminar el usuario");
				}
			}
		});
	}
	
	rerender(): void {
		this.dtElement.dtInstance.then((dtInstance: DataTables.Api) => {
			// Destroy the table first
			dtInstance.destroy();
			// Call the dtTrigger to rerender again
			this.dtTrigger.next();
		});
	}

}