import { NgModule } from "@angular/core";
import { TakeQuizListComponent } from "./components/list.component";
import { BrowserModule } from "@angular/platform-browser";
import { FormsModule } from "@angular/forms";
import { DataTablesModule } from "angular-datatables";
import { takeQuizRouting } from "./takeQuiz.routing";
import { TakeQuizComponent } from "./components/form.component";


@NgModule({
	declarations: [TakeQuizListComponent, TakeQuizComponent],
	imports     : [BrowserModule, FormsModule, DataTablesModule, takeQuizRouting],
})

export class TakeQuizModule {}