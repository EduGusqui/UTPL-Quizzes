import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute } from '@angular/router';
import { QuestionService } from '../../question/services/question.service';
import { Question } from '../../question/models/question';
import { AuthService } from '../../security/auth.service';
import swal from 'sweetalert2';
import { TakeQuizService } from '../services/takeQuiz.service';
import { TakeQuiz } from '../models/takeQuiz';
import { AssignQuiz } from '../../assignQuiz/models/assignQuiz';

@Component({
	templateUrl: 'form.component.html'
})

export class TakeQuizComponent implements OnInit {
	
	questions: Question[];
	takeQuiz: TakeQuiz;

	constructor(private router: Router, private route: ActivatedRoute, private questionService: QuestionService,
		private authService: AuthService, private takeQuizService: TakeQuizService
	) { }

	ngOnInit(): void {
		this.takeQuiz = new TakeQuiz();
		this.takeQuiz.Questions = [];
		this.takeQuiz.AssignQuiz = new AssignQuiz();
		this.route.params.subscribe((param: any) => {
			let idAssignation = param['idAssignation'];
			if (idAssignation != null) {
				this.takeQuiz.AssignQuiz.Id = idAssignation;
				this.questionService.getByAssignation(idAssignation).subscribe(questions => {
					this.takeQuiz.Questions = questions;
				}), error => {
					this.authService.showError("Ocurrió un error al cargar el cuestionario: " + error);
				}
			}
		});
	}

	chooseAnswer(idQuestion: number, idAnswer: number): void {
		this.takeQuiz.Questions.find(x => x.Id == idQuestion).AnswerSelected = idAnswer;
	}

	save(): void {
		if (this.takeQuiz.Questions.find(x => x.AnswerSelected == null)) {
			this.authService.showError("Debe responder todas las preguntas");
		} else {
			swal({
				title: '¿Está seguro?',
				text: 'El cuestionario sera enviado!',
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#0266b1',
				confirmButtonText: 'Si'
			}).then((result) => {
				if(result.value) {
					this.takeQuizService.create(this.takeQuiz).subscribe(response => {
						console.log(response);
						if (response != undefined) {
							this.authService.showSuccess("Cuestionario realizado correctamente.");
							this.router.navigate(['/takesQuizzes']);
						} else {
							this.authService.showError("Ocurrió un error al realizar el cuestionario. Comuniquese con el administrador");
						}
					});
				}
			});
		}
	}
}