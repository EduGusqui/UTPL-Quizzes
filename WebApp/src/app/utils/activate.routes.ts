import { Injectable } from '@angular/core';
import { CanActivate, Router, ActivatedRouteSnapshot, RouterStateSnapshot } from '@angular/router';
import { SessionService } from './session.service';
import { Observable } from 'rxjs';

@Injectable({
	providedIn: 'root'
})
export class ActivateRoutes implements CanActivate {

  constructor(private router: Router, private sessionService: SessionService) {}

  canActivate(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): Observable<boolean> | boolean {
	var token = sessionStorage.getItem('idToken');
	if (token != null) {
		if (this.sessionService.canNavigate(route.url[0].path)) {
			return true;
		} else {
			//this.router.navigate(['/mainView']);
			return false;
		}
	} else {
		sessionStorage.clear();
		this.router.navigate(['/login']);
		return false;
	}
  }
}