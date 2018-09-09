import { Injectable } from '@angular/core';
import { Constants } from './constants';
import { User } from '../users/models/user';
import { Rol } from '../roles/rol';

@Injectable({
	providedIn: 'root'
})
export class SessionService {
	routesForAdmin: Array<string> = ['mainView', 'users', 'users/edit', 'assignations', 
	'assignations/new', 'takesQuizzes', '/takesQuizzes/assignations'];
	routesForTeacher: Array<string> = ['mainView', 'assignations', 'assignations/new'];
  routesForStudent: Array<string> = ['mainView', 'takesQuizzes', '/takesQuizzes/assignations'];

	constructor(private constant: Constants) { }
	
	getUserLogged(): User {
		let userAuth = JSON.parse(sessionStorage.getItem("userLogged"));
		let user = new User();
		user.Id = userAuth.Id;
		user.Username = userAuth.Username;
		user.Rol = new Rol();
		user.Rol.Id = userAuth.IdRol;
    return user;
	}
	
	isInRol(rol: number): boolean {
		let userAuth = JSON.parse(sessionStorage.getItem("userLogged"));
		if (userAuth.IdRol == rol) {
			return true;
		} else {
			return false;
		}
	}
	
	canNavigate(url: string): boolean {
		let list: Array<string>;
		let userAuth = JSON.parse(sessionStorage.getItem("userLogged"));
		if (userAuth.IdRol == this.constant.ID_ROL_ADMIN) {
			list = this.routesForAdmin;
		}

		if (userAuth.IdRol == this.constant.ID_ROL_TEACHER) {
			list = this.routesForTeacher;
		}

		if (userAuth.IdRol == this.constant.ID_ROL_STUDENT) {
			list = this.routesForStudent;
		}

		for (let dir of list) {
			if (url == dir) {
				return true;
			}
		}

    return false;
  }
}