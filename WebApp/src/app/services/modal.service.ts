import { Injectable } from '@angular/core';

@Injectable({
	providedIn: 'root',
})
export class ModalService {

	private modals: any[] = [];

	//Agrega el modal a la lista de modales activos
	add(modal: any) {
		this.modals.push(modal);
	}

	//Elimina el modal de la lista de modales activos
	remove(id: string) {
		this.modals = this.modals.filter(x => x.id !== id);
	}

	//Abre el modal
	open(id: string) {
		let modal: any = this.modals.filter(x => x.id === id)[0];
		modal.open();
	}

	//Cierra el modal
	close(id: string) {
		let modal: any = this.modals.filter(x => x.id === id)[0];
		modal.close();
	}
}