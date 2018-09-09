import { Routes, RouterModule } from "@angular/router";
import { NavigationComponent } from "../layout/navigation.component";
import { AssignQuizListComponent } from "./components/list.component";
import { ActivateRoutes } from "../utils/activate.routes";
import { ModuleWithProviders } from "@angular/compiler/src/core";
import { AssignQuizComponent } from "./components/form.component";


const assignQuizRoutes: Routes = [
	{ path: '', component: NavigationComponent, 
        children: [
			{ path: 'assignations', component: AssignQuizListComponent, canActivate: [ActivateRoutes] },
			{ path: 'assignations/new', component: AssignQuizComponent, canActivate: [ActivateRoutes] }
		]
	}
]

export const assignQuizRouting: ModuleWithProviders = RouterModule.forChild(assignQuizRoutes);