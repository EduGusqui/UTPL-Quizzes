import { Injectable } from "@angular/core";
import { Response } from '@angular/http';
import { JwtHelperService  } from '@auth0/angular-jwt';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Router } from '@angular/router';
import { Observable, of } from 'rxjs';
import { User } from "../users/models/user";
import { catchError, map } from "rxjs/operators";
import swal from 'sweetalert2';
import { Constants } from "../utils/constants";
import { Authenticate } from "./authenticate";

const httpOptions = {
	headers: new HttpHeaders({
		'Content-Type': 'application/json'
	})
}

@Injectable({
	providedIn: 'root'
})
export class AuthService {
	private authUrl = 'login';
	public token: any;
	jwtHelper: JwtHelperService = new JwtHelperService();
	public clientId: string;
	public userName: string;

	constructor(private http: HttpClient, private router: Router, private constant: Constants ) {
		this.authUrl = this.constant.API_ENDPOINT + this.authUrl;
		this.clientId = this.constant.CLIENT_ID;
	}

	login(user: User): Observable<boolean> {
		return this.http.post(this.authUrl, user, httpOptions).pipe(
			map((response: Authenticate) => {
				let auth = response;
				if (auth != null) {
					this.token = auth.Token;
					sessionStorage.setItem('idToken', this.token);
					let obj: any = {
						"Id": auth.Id,
						"Username": auth.Username,
						"IdRol": auth.IdRol
					}
					sessionStorage.setItem('userLogged', JSON.stringify(obj));
					return true;
				} else {
					return false;
				}
			}),catchError(this.handleError('Login', false))
		);
		
	}

	logout(): void {
		this.token = null;
		sessionStorage.clear();
		this.router.navigate(['/login']);
	}

	isAuthorizeRequest(): boolean {
		let token = sessionStorage.getItem('idToken');
		if (token != null) {
			if (!this.jwtHelper.isTokenExpired(token)) {
				return true;
			} else {
				this.showExpired(100);
				return false;
			}
		}
	}
	
	showExpired(timeout?: number): void {
		let time = (timeout == undefined || timeout == null) ? 100 : timeout;
		setTimeout(() => {
			swal({
				title: 'Error',
				text: "Su sesión ha expirado",
				type: "error",
				confirmButtonColor: "#1a7bb9",
				confirmButtonText: "OK"
			}).then(() => {
				this.logout();
			})
		}, time);
	}

	showError(error: any) {
		if (error == "" || error == "Token expirado") {
			this.showExpired(300);
		} else {
			setTimeout(() => {
				swal({
					title: "Error",
					text: error,
					type: "error",
					confirmButtonColor: "#1a7bb9",
					confirmButtonText: "OK"
				});
			}, 100);
		}
	}

	showInfo(ok: any) {
		setTimeout(() => {
			swal({
				title: "",
				text: ok,
				type: "info",
				confirmButtonColor: "#1a7bb9",
				confirmButtonText: "OK"
			});
		}, 100);
	}

	showSuccess(ok: any) {
		setTimeout(() => {
			swal({
				title: "",
				text: ok,
				type: "success",
				confirmButtonColor: "#1a7bb9",
				confirmButtonText: "OK"
			});
		}, 100);
	}

	getExpiredError() {
		return Observable.throw("Token expirado");
	}

	extractData(res: Response) {
		let body = res.json();
		return body || {};
	}

	handleError<T> (operation = 'operation', result?: T) {
		return (error: any): Observable<T> => {
			console.error("Error al ejecutar: " + operation)
			console.error(error);
			return of(result as T);
		};
	}
}