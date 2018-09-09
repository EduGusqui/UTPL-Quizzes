import { NgModule } from "@angular/core";
import { BrowserModule } from '@angular/platform-browser';
import { HttpClientModule }    from '@angular/common/http';
import { LoginComponent } from "./login.component";
import { ReactiveFormsModule, FormsModule } from '@angular/forms';


@NgModule({
    declarations: [LoginComponent],
    imports: [BrowserModule, HttpClientModule, ReactiveFormsModule, FormsModule]
})

export class LoginModule { }