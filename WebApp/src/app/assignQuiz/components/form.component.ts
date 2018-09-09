import { Component, OnInit } from "@angular/core";
import { User } from "../../users/models/user";
import { Quiz } from "../../quiz/models/quiz";
import { UserService } from "../../users/services/user.service";
import { Constants } from "../../utils/constants";
import { AssignQuiz } from "../models/assignQuiz";
import { QuizService } from "../../quiz/services/quiz.services";
import { AssignQuizService } from "../services/assignQuiz.service";
import { AuthService } from "../../security/auth.service";
import { Router } from "@angular/router";
import { SessionService } from "../../utils/session.service";

@Component({
	templateUrl: 'form.component.html'
})

export class AssignQuizComponent implements OnInit {

	teachers: User[];
	quizzes: Quiz[];
	students: User[];
	assignQuiz: AssignQuiz;
	show: boolean;

	constructor(private router: Router, private userService: UserService, private quiService: QuizService, 
		private assignQuizService: AssignQuizService, private constants: Constants, private authService: AuthService,
		private sessionService: SessionService
	) { }

	ngOnInit(): void {
		this.assignQuiz = new AssignQuiz();
		this.assignQuiz.Teacher = new User();
		this.assignQuiz.Teacher.Id = null;
		this.assignQuiz.Quiz = new Quiz();
		this.assignQuiz.Quiz.Id = null;
		
		if (this.sessionService.isInRol(this.constants.ID_ROL_ADMIN)) {
			this.show = true;
			this.userService.getUserByRol(this.constants.ID_ROL_TEACHER).subscribe(teachers => {
				this.teachers = teachers;
			});
		} else {
			this.show = false;
			let user = this.sessionService.getUserLogged();
			this.assignQuiz.Teacher.Id = user.Id;
			this.loadQuizzes();
		}

		this.userService.getUserByRol(this.constants.ID_ROL_STUDENT).subscribe(students => {
			this.students = students;
		});
	}

	loadQuizzes(): void {
		this.quiService.getQuizByUserId(this.assignQuiz.Teacher.Id).subscribe(quizzes => {
			this.quizzes = quizzes;
		});
	}

	selectStudents(selectElement: any) {
		this.assignQuiz.Students = [];
		for (var i = 0; i < selectElement.options.length; i++) {
			var optionElement = selectElement.options[i];
			var optionModel = this.students[i];
			if (optionElement.selected == true) { 
				this.assignQuiz.Students.push(optionModel);
			}
		}
	}

	save() {
		this.assignQuizService.create(this.assignQuiz).subscribe(response => {
			if (response != undefined) {
				this.authService.showSuccess("Cuestionario asignado correctamente");
				this.router.navigate(['/assignations']);
			} else {
				this.authService.showError("Ocurrió un error al asignar el cuestionario. Comuniquese con el administrador");
			}
		});
	}
}