import { Component, OnInit, ElementRef, ViewChild } from '@angular/core';
import { Router, ActivatedRoute } from '@angular/router';
import { FormGroup } from '@angular/forms';
import { User } from '../../model/user';
import { UserService } from '../../services/user.service';

@Component({
	templateUrl: 'form.component.html'
})

export class UserComponent implements OnInit {
	/*form: FormGroup;
	formSumitAttempt: boolean;*/
	user: User;

	constructor(private router: Router, private route: ActivatedRoute
	) { }
	
	ngOnInit(): void {
		this.user = new User();
	}

	save(): void {
		console.log('Guardando');
	}

}