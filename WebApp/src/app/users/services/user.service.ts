import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable, of } from 'rxjs';
import { catchError } from 'rxjs/operators';
import { User } from '../models/user';
import { AppAuthHttp } from '../../security/appAuthHttp';
import { Constants } from '../../utils/constants';


const httpOptions = {
	headers: new HttpHeaders({ 'Content-Type': 'application/json' })
};

@Injectable({
	providedIn: 'root',
})

export class UserService {
	private userUrl = "users";

	constructor(private http: HttpClient, private authHttp: AppAuthHttp, private constants: Constants) { 
		this.userUrl = this.constants.API_ENDPOINT + this.userUrl;
	}

	getAll(): Observable<User[]> {
		return this.authHttp.get(this.userUrl).pipe(catchError(this.handleError('GetAll', [])))
	}

	getUser(id): Observable<User> {
		return this.http.get(this.userUrl + "/" + id).pipe(catchError(this.handleError('getUser', new User())));
	}

	getUserByRol(idRol: number): Observable<User[]> {
		return this.http.get<User[]>(this.userUrl + "/byRol/" + idRol)
		.pipe(catchError(this.handleError('getUserByRol', [])));
	}

	create(user: User): Observable<User> {
		return this.http.post(this.userUrl, user, httpOptions).pipe(catchError(this.handleError('create')));
	}

	update(user: User): Observable<User> {
		return this.http.put(this.userUrl, user, httpOptions).pipe(catchError(this.handleError('update')));
	}

	delete(id: number): Observable<any> {
		return this.http.delete(this.userUrl + "/" + id).pipe(catchError(this.handleError('delete')));
	}

	handleError<T> (operation = 'operation', result?: T) {
		return (error: any): Observable<T> => {
			console.error("Error al ejecutar: " + operation)
			console.error(error);
			return of(result as T);
		};
	}
}