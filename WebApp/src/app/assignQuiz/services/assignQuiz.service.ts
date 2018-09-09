import { Injectable } from '@angular/core';
//import { HttpHeaders, HttpClient } from '@angular/common/http';
import { AppAuthHttp } from '../../security/appAuthHttp';
import { Constants } from '../../utils/constants';
import { Observable, of } from 'rxjs';
import { AssignQuiz } from '../models/assignQuiz';
import { catchError } from 'rxjs/operators';

@Injectable({
	providedIn: 'root',
})

export class AssignQuizService {

	private assignUrl = 'assignations';

	constructor(private authHttp: AppAuthHttp, private constants: Constants) {
		this.assignUrl = this.constants.API_ENDPOINT + this.assignUrl;
	}

	getAll(): Observable<AssignQuiz[]> {
		return this.authHttp.get(this.assignUrl).pipe(catchError(this.handleError('GetAll', [])));
	}

	getByUser(idUser: number): Observable<AssignQuiz[]> {
		return this.authHttp.get(this.assignUrl + "/byUser/" + idUser).pipe(catchError(this.handleError('GetByUser', [])));
	}

	create(assignQuiz: AssignQuiz): Observable<any> {
		let body = JSON.stringify(assignQuiz);
		return this.authHttp.post(this.assignUrl, body).pipe(catchError(this.handleError('create')));
	}

	delete(id: number): Observable<any> {
		return this.authHttp.delete(this.assignUrl + "/" + id).pipe(catchError(this.handleError('delete')));
	}

	handleError<T> (operation = 'operation', result?: T) {
    return (error: any): Observable<T> => {
      console.error("Error al ejecutar: " + operation)
      console.error(error);
      return of(result as T);
		};
	}
	
}