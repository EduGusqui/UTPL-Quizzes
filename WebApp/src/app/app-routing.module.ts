import { NgModule, ModuleWithProviders } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { LoginComponent } from './login/login.component';
import { ActivateRoutes } from './utils/activate.routes';
import { MainViewComponent } from './main/main.component';
import { NavigationComponent } from './layout/navigation.component';

const routes: Routes = [
	// Main redirect
	{ path: '', redirectTo: 'mainView', pathMatch: 'full' },

	// App views
  {
    path: '', component: NavigationComponent, 
    children: [
      { path: 'mainView', component: MainViewComponent, canActivate: [ActivateRoutes] }
    ]
	},

	{ path: '', 
		children: [
			{ path: 'login', component: LoginComponent }
		]
	}
	
	
];

/*@NgModule({
	imports: [ RouterModule.forRoot(routes) ],
	exports: [ RouterModule ]
})

export class AppRoutingModule {}*/
export const appRoutingProviders: any[] = [

];

export const routing: ModuleWithProviders = RouterModule.forRoot(routes, {useHash: true});