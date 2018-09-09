import { Injectable } from "@angular/core";
import { HttpClient, HttpHeaders } from "@angular/common/http";
import { AppAuthHttp } from "../../security/appAuthHttp";
import { Constants } from "../../utils/constants";
import { Observable, of } from "rxjs";
import { Quiz } from "../models/quiz";
import { catchError } from "rxjs/operators";


const httpOptions = {
	headers: new HttpHeaders({ 'Content-Type': 'application/json' })
};

@Injectable({
	providedIn: 'root',
})

export class QuizService {
	private quizUrl = "quizzes";

	constructor(private http: HttpClient, private authHttp: AppAuthHttp, private constants: Constants) { 
		this.quizUrl = this.constants.API_ENDPOINT + this.quizUrl;
	}

	getQuizByUserId(idUser: number): Observable<Quiz[]> {
		return this.authHttp.get(this.quizUrl + "/byUser/" + idUser).pipe(catchError(this.handleError('getQuizByUser', [])));
	}

	handleError<T> (operation = 'operation', result?: T) {
		return (error: any): Observable<T> => {
			console.error("Error al ejecutar: " + operation)
			console.error(error);
			return of(result as T);
		};
	}
}