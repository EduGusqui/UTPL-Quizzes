import { Component, OnInit, ViewChild } from '@angular/core';
import { DataTableDirective } from 'angular-datatables';
import { AssignQuiz } from '../models/assignQuiz';
import { Subject } from 'rxjs';
import { AssignQuizService } from '../services/assignQuiz.service';
import { AuthService } from '../../security/auth.service';
import { SessionService } from '../../utils/session.service';
import { Constants } from '../../utils/constants';
import swal from 'sweetalert2';


@Component({
	templateUrl: 'list.component.html'
})

export class AssignQuizListComponent implements OnInit {
	@ViewChild(DataTableDirective)
	dtElement: DataTableDirective;

	assignations: AssignQuiz[];
	dtOptions: any = {};
	dtTrigger: Subject<string> = new Subject();
	show: boolean;
	
	constructor(private assignQuizService: AssignQuizService, private authService: AuthService,
		private sessionService: SessionService, private constants: Constants
	) { }

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

		if (this.sessionService.isInRol(this.constants.ID_ROL_ADMIN)) {
			this.show = true;
		} else {
			this.show = false;
		}
		
		this.assignQuizService.getAll().subscribe(assignations => {
			this.assignations = assignations;
			this.dtTrigger.next();
		}), error => {
			this.authService.showError("Ocurrió un error al cargar las asignaciones: " + error);
		}
	}

	ngOnDestroy(): void {
		this.dtTrigger.unsubscribe();
	}

	delete(idUser: number) {
		swal({
			title: '¿Está seguro?',
			text: 'Va a eliminar la asignación del cuestionario!',
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#0266b1',
			confirmButtonText: 'Si, eliminelo'
		}).then((result) => {
			if(result.value) {
				this.assignQuizService.delete(idUser).subscribe(() => {
					this.assignQuizService.getAll().subscribe(assignations => {
						this.assignations = assignations;
						this.rerender();
						this.authService.showSuccess("Asignación de cuestionario eliminado con éxito.");
					}), error => {
						this.authService.showError("Ocurrió un error al cargar las asignaciones" + error);
					}
				}), error => {
					this.authService.showError("Ocurrió un error al eliminar la asignación" + error);
				}
			}
		});
	}

	rerender(): void {
		this.dtElement.dtInstance.then((dtInstance: DataTables.Api) => {
			dtInstance.destroy();
			this.dtTrigger.next();
		});
	}
}