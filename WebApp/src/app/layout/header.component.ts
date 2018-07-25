import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';

@Component({
	selector: 'app-header',
	templateUrl: 'header.template.html'
})

export class AppHeaderComponent implements OnInit {
	systemName: string;
	constructor(private router: Router) { }

	ngOnInit(): void {
		this.systemName = "Sistema de Gestión de cuestionarios UTPL"
	}

	activeRoute(routename: string): boolean {
		return this.router.url.indexOf(routename) > -1;
	}
}