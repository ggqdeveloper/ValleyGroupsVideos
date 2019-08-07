import {NgModule} from '@angular/core';
import {Routes, RouterModule} from '@angular/router';
import {LoginComponent} from "./login/login.component";
import {DefaultComponent} from "./default/default.component";
import {RegisterComponent} from "./register/register.component";
import {UserComponent} from "./user/user.component";
import {VideoComponent} from "./video/video.component";


const routes: Routes = [
  {path: '', redirectTo: '/default', pathMatch: 'full'},
  {path: 'default', component: DefaultComponent},
  {path: 'register', component: RegisterComponent},
  {path: 'login', component: LoginComponent},
  {path: 'login/:id', component: LoginComponent},
  {path: 'user', component: UserComponent},
  {path: 'video', component: VideoComponent},
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule {
}
