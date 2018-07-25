import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable, of } from 'rxjs';
import { catchError, map, tap } from 'rxjs/operators';

import { User } from '../model/user';

const httpOptions = {
	headers: new HttpHeaders({ 'Content-Type': 'application/json' })
};

@Injectable({
  providedIn: 'root',
})

export class UserService {
	private userUrl = "/api/users";

	constructor(private http: HttpClient) { }

	GetAll(): Observable<User[]> {
		return this.http.get<User[]>(this.userUrl)
		.pipe(
			catchError(this.handleError('GetAll', []))
		)
	}

	deleteUser(id: number): Observable<any> {
		console.log(this.userUrl + "/" + id)
		return this.http.delete(this.userUrl + "/" + id)
		.pipe(
			catchError(this.handleError('deleteUser'))
		)
	}

	handleError<T> (operation = 'operation', result?: T) {
    return (error: any): Observable<T> => {
      console.error("Error al ejecutar: " + operation)
      console.error(error);
      return of(result as T);
    };
  }
}