import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { NavigationComponent } from './layout/navigation.component';
import { UserListComponent } from './components/user/list.component';
import { UserComponent } from './components/user/form.component';

const routes: Routes = [
	{ path: '', redirectTo: 'users', pathMatch: 'full'},

	{ path: '', component: NavigationComponent, 
		children: [
			{ path: 'users', component: UserListComponent },
			{ path: 'users/create', component: UserComponent }
		]
	},
	
	{ path: '', component: NavigationComponent, 
		children: [
			{ path: 'create', component: UserComponent }
		]
	}
];

@NgModule({
	imports: [ RouterModule.forRoot(routes) ],
	exports: [ RouterModule ]
})

export class AppRoutingModule {}