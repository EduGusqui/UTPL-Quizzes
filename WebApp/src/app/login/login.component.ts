import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { User } from '../users/models/user';
import { AuthService } from '../security/auth.service';



@Component({
	providers: [],
	selector: 'login',
	templateUrl: 'login.component.html'
})
export class LoginComponent implements OnInit {

	user: User;
	error: string;

	constructor(private router: Router, private authService: AuthService) { }

	ngOnInit() {
		this.user = new User();
	}

	login() {
		this.authService.login(this.user).subscribe(result => {
			if (result) {  
				this.router.navigate(['/mainView']);
			} else {
				this.error = "No existe el usuario, verifique las credenciales ingresadas."
			}
		}, error => {
			if (error.status == '504') {
				this.error = "No existe conexión. Tiempo de espera agotado.";
			}
			else if (error.json().error == 'invalid_grant' || error.json().error == 'internal_error')
				this.error = error.json().error_description;
			else {
				this.error = error;
			}	
		});
	}
}