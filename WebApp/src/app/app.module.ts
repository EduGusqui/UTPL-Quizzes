import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { HttpClientModule }    from '@angular/common/http';
import { ReactiveFormsModule, FormsModule }   from '@angular/forms';

import { AppComponent } from './app.component';
import { AppRoutingModule } from './app-routing.module';
import { NavigationComponent } from './layout/navigation.component';
import { AppHeaderComponent } from './layout/header.component';
import { AppMenuComponent } from './layout/menu.component';
import { AppFooterComponent } from './layout/footer.component';

import { UserListComponent } from './components/user/list.component';
import { UserComponent } from './components/user/form.component';
import { ModalComponent } from './components/modal/modal.component';

@NgModule({
  declarations: [
    AppComponent,
    NavigationComponent,
    AppHeaderComponent,
    AppMenuComponent,
    AppFooterComponent,
    UserComponent,
    UserListComponent,
    ModalComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    HttpClientModule,
    ReactiveFormsModule,
    FormsModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
