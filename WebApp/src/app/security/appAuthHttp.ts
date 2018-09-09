import { Injectable } from "@angular/core";
import { AuthService } from "./auth.service";
import { RequestOptionsArgs, RequestMethod, RequestOptions } from "@angular/http";
import { HttpHeaders, HttpRequest, HttpClient } from "@angular/common/http";
import { Observable } from "rxjs";

const httpOptions = {
	headers: new HttpHeaders({
		'Accept': 'application/json',
		'Content-Type': 'application/json'
	})
}

@Injectable({
	providedIn: 'root'
})
export class AppAuthHttp {
	
	constructor(private http: HttpClient , private authService: AuthService){}

	get(url: string) {
		return this._request('GET', url, null);
	}

	post(url: string, body: string) {
		return this._request('POST', url, body);
	}

	put(url:string, body: string) {
		return this._request('PUT', url, body);
	}

	delete(url:string) {
		return this._request('DELETE', url);
	}

	private _request(method: string, url: string, body?: string): Observable<any> {
		if (this.authService.isAuthorizeRequest()) {
			return this.http.request(method, url, 
			{
				body,
				headers: new HttpHeaders({
					'Accept': 'application/json',
					'Content-Type': 'application/json'
				})
			});
		} else {
			return this.authService.getExpiredError();
		}
	}
}