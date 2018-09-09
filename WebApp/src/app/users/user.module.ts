import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { userRouting } from './user.routing';
import { UserListComponent } from './components/list.component';
import { DataTablesModule } from 'angular-datatables';

@NgModule({
    declarations: [UserListComponent],
    imports     : [BrowserModule, DataTablesModule, userRouting],
})

export class UserModule {}