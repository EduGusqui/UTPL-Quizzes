import { Injectable } from "@angular/core";
import { AppAuthHttp } from "../../security/appAuthHttp";
import { Constants } from "../../utils/constants";
import { Observable, of } from "rxjs";
import { TakeQuiz } from "../models/takeQuiz";
import { catchError } from "rxjs/operators";


@Injectable({
	providedIn: 'root',
})

export class TakeQuizService {

	private takeQuizUrl = 'takesQuizzes';

	constructor(private authHttp: AppAuthHttp, private constants: Constants) {
		this.takeQuizUrl = this.constants.API_ENDPOINT + this.takeQuizUrl;
	}

	getAll(): Observable<TakeQuiz[]> {
		return this.authHttp.get(this.takeQuizUrl).pipe(catchError(this.handleError('GetAll', [])));
	}

	create(questions: any): Observable<any> {
		let body = JSON.stringify(questions);
		return this.authHttp.post(this.takeQuizUrl, body).pipe(catchError(this.handleError('create')));
	}

	delete(id: number): Observable<any> {
		return this.authHttp.delete(this.takeQuizUrl + "/" + id).pipe(catchError(this.handleError('delete')));
	}

	handleError<T> (operation = 'operation', result?: T) {
    return (error: any): Observable<T> => {
      console.error("Error al ejecutar: " + operation)
      console.error(error);
      return of(result as T);
		};
	}
	
}