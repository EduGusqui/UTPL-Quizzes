import { BrowserModule } from '@angular/platform-browser';
import { NgModule, APP_INITIALIZER } from '@angular/core';
import { HttpClientModule }    from '@angular/common/http';
import { DataTablesModule } from 'angular-datatables';
import { FormsModule } from '@angular/forms';

import { AppComponent } from './app.component';
import { HTTP_INTERCEPTORS } from '@angular/common/http';
import { JwtInterceptor } from './helpers/jwt.interceptor';
import { ErrorInterceptor } from './helpers/error.interceptor';
import { LoginModule } from './login/login.module';
import { AppConfig } from './app.config';
import { MainViewModule } from './main/main.module';
import { UserModule } from './users/user.module';
import { NavigationComponent } from './layout/navigation.component';
import { MenuComponent } from './layout/menu.component';
import { HeaderComponent } from './layout/header.component';
import { FooterComponent } from './layout/footer.component';
import { appRoutingProviders, routing } from './app-routing.module';
import { AssignQuizModule } from './assignQuiz/assignQuiz.module';
import { TakeQuizModule } from './takeQuiz/takeQuiz.module';

/*export function appConfigServiceFactory(appConfig: AppConfig) {
  return () => appConfig.load();
};*/

@NgModule({
  declarations: [
    AppComponent, NavigationComponent, MenuComponent, HeaderComponent,
    FooterComponent
  ],
  imports: [
    BrowserModule, HttpClientModule, FormsModule, DataTablesModule, routing, LoginModule,
    MainViewModule, UserModule, AssignQuizModule, TakeQuizModule
  ],
  providers: [ appRoutingProviders,
    { provide: HTTP_INTERCEPTORS, useClass: JwtInterceptor, multi: true },
    { provide: HTTP_INTERCEPTORS, useClass: ErrorInterceptor, multi: true },
    //{ provide: APP_INITIALIZER, useFactory: appConfigServiceFactory, deps: [AppConfig], multi: true }
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
