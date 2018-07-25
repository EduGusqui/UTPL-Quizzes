import { Component, OnInit, ElementRef} from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
	selector: 'app-menu',
	templateUrl: 'menu.component.html'
})

export class AppMenuComponent implements OnInit {
	constructor(private route: ActivatedRoute, private _router: Router,
		private elementRef:ElementRef) { }

	ngOnInit(){ }

	activeRoute(path: string): boolean {
		return true;
	}
} 