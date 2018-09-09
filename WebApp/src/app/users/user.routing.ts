import { Routes, RouterModule } from "@angular/router";
import { ModuleWithProviders } from "@angular/core";
import { UserListComponent } from "./components/list.component";
import { ActivateRoutes } from "../utils/activate.routes";
import { NavigationComponent } from "../layout/navigation.component";


const userRoutes: Routes = [
	//{ path: 'users', component: UserListComponent, canActivate: [ActivateRoutes]},
	{ path: '', component: NavigationComponent, 
    children: [
      { path: 'users', component: UserListComponent, canActivate: [ActivateRoutes] }
		]
	}
]

export const userRouting: ModuleWithProviders = RouterModule.forChild(userRoutes);