import { Component, OnInit, ElementRef, Input, OnDestroy } from '@angular/core';
import { ModalService } from '../../services/modal.service';

@Component({
	selector: 'modal',
	template: '<ng-content></ng-content>'
})

export class ModalComponent implements OnInit, OnDestroy {
	@Input() id: string;
	private element: any;
	title: string;
	description: string;

	constructor(private modalService: ModalService, private el: ElementRef) {
		this.element = el.nativeElement;
	}

	ngOnInit(): void {
		let modal = this;

		//Verifica que el identificador del modal exista
		if (!this.id) {
			return;
		}

		// Coloca el modal por encima del body
		document.body.appendChild(this.element);

		// Cierra el modal si se da click fuera de el
		this.element.addEventListener('click', function (e: any) {
			if (e.target.className === 'modal') {
				modal.close();
			}
		});

		// Se agrega la instancia para el servicio sea accesible
		this.modalService.add(this);
	}

	// Elimina el modal
	ngOnDestroy(): void {
		this.modalService.remove(this.id);
		this.element.remove();
	}

	// Abre el modal
	open(title: string, desciption: string): void {
		this.title = title;
		this.description = desciption;
		this.element.style.display = 'block';
		document.body.classList.add('modal-open');
	}

	// Cierra el modal
	close(): void {
		this.element.style.display = 'none';
		document.body.classList.remove('modal-open');
	}
}