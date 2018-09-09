import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { assignQuizRouting } from './assignQuiz.routing';
import { AssignQuizListComponent } from './components/list.component';
import { DataTablesModule } from 'angular-datatables';
import { AssignQuizComponent } from './components/form.component';
import { FormsModule } from '@angular/forms';


@NgModule({
    declarations: [AssignQuizListComponent, AssignQuizComponent],
    imports     : [BrowserModule, FormsModule, DataTablesModule, assignQuizRouting],
})

export class AssignQuizModule {}