import { Injectable } from "@angular/core";
import { HttpClient } from "@angular/common/http";
import { catchError } from "rxjs/operators";
import { Observable, of } from "rxjs";
import { Authenticate } from "./security/authenticate";

@Injectable({
	providedIn: "root"
})

export class AppConfig {
	constructor(private http: HttpClient) { }

	public load() {   
		return new Promise((resolve) => {
			this.http.get('/api/users/byUserLogged')
				.pipe(catchError(this.handleError('getAnswer', 'Error al cargar las funcionalidades')))
				.subscribe((auth: Authenticate) => {
					let obj: any = {
						"Id": auth.Id,
						"Username": auth.Username,
						"IdRol": auth.IdRol
					}
					sessionStorage.setItem("userLogged", JSON.stringify(obj));
					let request:any = null;
					resolve(true);
				});
		});
	}

	handleError<T> (operation = 'operation', result?: T) {
		return (error: any): Observable<T> => {
			console.error("Error al ejecutar: " + operation)
			console.error(error);
			return of(result as T);
		};
	}
}