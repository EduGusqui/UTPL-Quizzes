import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { SessionService } from '../utils/session.service';
import { Constants } from '../utils/constants';

declare var jQuery:any;

@Component({
	selector: 'app-menu',
	templateUrl: 'menu.component.html'
})

export class MenuComponent {
	constructor(private router: Router, public sessionService: SessionService, private constants: Constants) {
	}

	ngAfterViewInit() {
		jQuery('#side-menu').metisMenu();
	}

	activeRoute(path: string): boolean {
		if (path === this.constants.ROL_ADMIN) {
			if (this.router.url === '/users') {
				return true;
			} else {
				return false;
			}
		}

		if (path === this.constants.ROL_TEACHER) {
			if (this.router.url === '/quizzes') {
				return true;
			} else {
				return false;
			}
		}

		if (path === this.constants.ROL_STUDENT) {
			if (this.router.url === '/takesQuizzes') {
				return true;
			} else {
				return false;
			}
		}

		return false;
	}
}