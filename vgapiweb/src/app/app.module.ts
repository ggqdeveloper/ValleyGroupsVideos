import {BrowserModule} from '@angular/platform-browser';
import {NgModule} from '@angular/core';

import {AppRoutingModule} from './app-routing.module';
import {AppComponent} from './app.component';
import {LoginComponent} from './login/login.component';
import {DefaultComponent} from './default/default.component';
import {RegisterComponent} from './register/register.component';
import {AlertModule, BsDropdownModule, ButtonsModule} from "ngx-bootstrap"
import {FormsModule} from "@angular/forms";
import {HttpClientModule} from "@angular/common/http";
import {UserComponent} from './user/user.component';



@NgModule({
  declarations: [
    AppComponent,
    LoginComponent,
    DefaultComponent,
    RegisterComponent,
    UserComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    AlertModule,
    ButtonsModule,
    BsDropdownModule,
    FormsModule,
    HttpClientModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule {
}
