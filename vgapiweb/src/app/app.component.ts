import {Component} from '@angular/core';
import {LoginService} from "./services/login.service";

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.sass'],
  providers: [LoginService]
})
export class AppComponent {
  public identity;
  public token;

  title = 'YouVideos';

  constructor(
    private _loginService: LoginService
  ) {
    this.identity = this._loginService.getIdentity();
    this.token = this._loginService.getToken();
  }

  ngOnInit() {
  }
}
