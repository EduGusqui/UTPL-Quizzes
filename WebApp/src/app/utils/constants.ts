import { Injectable } from "@angular/core";

@Injectable({
	providedIn: 'root'
})
export class Constants {
	API_ENDPOINT: string;
	CLIENT_ID: string;
	ID_ROL_ADMIN: number;
	ID_ROL_TEACHER: number;
	ID_ROL_STUDENT: number;
	ROL_ADMIN: string;
	ROL_TEACHER: string;
	ROL_STUDENT: string;

	constructor() {
		this.API_ENDPOINT = '/api/';
		this.CLIENT_ID = '8a3e4d10b2b24d6b9c55c88a95fdc324';
		this.ID_ROL_ADMIN = 1;
		this.ID_ROL_TEACHER = 2;
		this.ID_ROL_STUDENT = 3;
		this.ROL_ADMIN = 'amd';
		this.ROL_TEACHER = 'teacher';
		this.ROL_STUDENT = 'student';
	}
}
