import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { AuthService } from '../security/auth.service';
//import { smoothlyMenu } from '../app.helpers';
//import { correctHeight } from '../app.helpers';

declare var jQuery:any;

@Component({
    selector: 'app-header',
    templateUrl: 'header.component.html'
})
export class HeaderComponent {

	constructor(private router: Router, private authService: AuthService) { }

	/*toggleNavigation(): void {
		jQuery("body").toggleClass("mini-navbar");
		smoothlyMenu();
	}

	ngAfterViewInit() {
		jQuery('.goHome').click(() => {
			setTimeout(() => {
				correctHeight();
			}, 300)
		});
	}*/

	logout(): void {
		this.authService.logout();
	}
}