import { Routes, RouterModule } from "@angular/router";
import { NavigationComponent } from "../layout/navigation.component";
import { ActivateRoutes } from "../utils/activate.routes";
import { ModuleWithProviders } from "@angular/compiler/src/core";
import { TakeQuizListComponent } from "./components/list.component";
import { TakeQuizComponent } from "./components/form.component";


const takeQuizRoutes: Routes = [
	{ path: '', component: NavigationComponent, 
		children: [
			{ path: 'takesQuizzes', component: TakeQuizListComponent, canActivate: [ActivateRoutes] },
			{ path: 'takesQuizzes/assignations/:idAssignation', component: TakeQuizComponent, canActivate: [ActivateRoutes] }
		]
	}
]

export const takeQuizRouting: ModuleWithProviders = RouterModule.forChild(takeQuizRoutes);