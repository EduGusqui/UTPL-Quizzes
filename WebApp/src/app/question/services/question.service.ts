import { Injectable } from '@angular/core';
import { AppAuthHttp } from '../../security/appAuthHttp';
import { Constants } from '../../utils/constants';
import { Observable, of } from 'rxjs';

import { catchError } from 'rxjs/operators';
import { Question } from '../models/question';

@Injectable({
	providedIn: 'root',
})

export class QuestionService {

	private questionUrl = 'questions';

	constructor(private authHttp: AppAuthHttp, private constants: Constants) {
		this.questionUrl = this.constants.API_ENDPOINT + this.questionUrl;
	}

	getAll(): Observable<Question[]> {
		return this.authHttp.get(this.questionUrl).pipe(catchError(this.handleError('GetAll', [])));
	}

	getByAssignation(idAssignation: number): Observable<Question[]> {
		return this.authHttp.get(this.questionUrl + "/byAssignation/" + idAssignation).pipe(catchError(this.handleError('getByAssignation', [])));
	}

	create(assignQuiz: Question): Observable<any> {
		let body = JSON.stringify(assignQuiz);
		return this.authHttp.post(this.questionUrl, body).pipe(catchError(this.handleError('create')));
	}

	delete(id: number): Observable<any> {
		return this.authHttp.delete(this.questionUrl + "/" + id).pipe(catchError(this.handleError('delete')));
	}

	handleError<T> (operation = 'operation', result?: T) {
    return (error: any): Observable<T> => {
      console.error("Error al ejecutar: " + operation)
      console.error(error);
      return of(result as T);
		};
	}
	
}