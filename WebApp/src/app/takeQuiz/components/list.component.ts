import { Component, OnInit, ViewChild } from "@angular/core";
import { DataTableDirective } from "angular-datatables";
import { SessionService } from "../../utils/session.service";
import { Constants } from "../../utils/constants";
import { Subject } from "rxjs";
import { TakeQuiz } from "../models/takeQuiz";
import { TakeQuizService } from "../services/takeQuiz.service";
import { AuthService } from "../../security/auth.service";
import { AssignQuizService } from "../../assignQuiz/services/assignQuiz.service";
import { AssignQuiz } from "../../assignQuiz/models/assignQuiz";
import swal from 'sweetalert2';
import { Router } from "@angular/router";

@Component({
	templateUrl: 'list.component.html'
})

export class TakeQuizListComponent implements OnInit {
	@ViewChild(DataTableDirective)
	dtElement: DataTableDirective;

	dtOptions: any = {};
	dtTrigger: Subject<string> = new Subject();
	takesQuizzes: TakeQuiz[];
	assignations: AssignQuiz[];

	constructor(private router: Router, private sessionService: SessionService, private constants: Constants, 
		private takeQuizService: TakeQuizService, private authService: AuthService, private assignQuizService: AssignQuizService
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
			this.assignQuizService.getAll().subscribe(assignations => {
				this.assignations = assignations;
				this.dtTrigger.next();
			}), error => {
				this.authService.showError("Ocurrió un error al cargar las asignaciones: " + error);
			}
		} else {
			let user = this.sessionService.getUserLogged();
			this.assignQuizService.getByUser(user.Id).subscribe(assignations => {
				this.assignations = assignations;
				this.dtTrigger.next();
			}), error => {
				this.authService.showError("Ocurrió un error al cargar las asignaciones: " + error);
			}
		}		
	}

	ngOnDestroy(): void {
		this.dtTrigger.unsubscribe();
	}

	takeQuiz(idAssignation: number): void {
		swal({
			title: '¿Está seguro?',
			text: 'Va a rendir el cuestionario!',
			type: 'info',
			showCancelButton: true,
			confirmButtonColor: '#0266b1',
			confirmButtonText: 'Si'
		}).then((result) => {
			if(result.value) {
				this.router.navigate(['/takesQuizzes/assignations/' + idAssignation]);
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