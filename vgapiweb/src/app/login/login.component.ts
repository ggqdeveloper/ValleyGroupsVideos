import {Component, OnInit} from '@angular/core';
import {LoginService} from "../services/login.service";
import {VideoService} from "../services/video.service";
import {ActivatedRoute, Router} from "@angular/router";

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.sass'],
  providers: [LoginService]
})
export class LoginComponent implements OnInit {

  public title = 'Login';
  public user;
  public errorMessage;
  public identity;
  public token;
  public idLogin;

  constructor(
    private _loginService: LoginService,
    private _route: ActivatedRoute,
    private _router: Router
  ) {
    this.idLogin = 2;
  }

  ngOnInit() {
    this.user = {
      "email": "",
      "password": "",
      "getToken": true,
    };

    this._route.params.subscribe(params => {
      let logout = +params["id"];
      if (logout == 1) {
        localStorage.removeItem('identity');
        localStorage.removeItem('token');
        this.identity = null;
        this.token = null;

        window.location.href = "/login";
        // this._router.navigate(["/index"]);
      }
    });
  }

  onSubmit() {
    this._loginService.signup(this.user).subscribe(
      response => {
        let identity = response;
        this.identity = identity;
        console.log(this.identity);
        if (this.identity.length <= 1) {
          alert("Error en el servidor");
        } else {

          if (!this.identity.original) {
            localStorage.setItem('identity', JSON.stringify(identity));
            this.idLogin = 1;

            // GET TOKEN
            this.user.getToken = false;
            this._loginService.signup(this.user).subscribe(
              response => {
                let token = response;
                this.token = token;

                if (this.token.length <= 0) {
                  alert("Error en el servidor");
                } else {
                  if (!this.token.status) {
                    localStorage.setItem('token', token);

                    // REDIRECCION
                    window.location.href = "/";
                  }
                }
              },
              error => {
                this.errorMessage = <any>error;

                if (this.errorMessage != null) {
                  console.log(this.errorMessage);
                  alert("Error en la petición");
                }
              }
            );

          } else {
            this.idLogin = 0;
          }
        }

      },
      error => {
        this.errorMessage = <any>error;

        if (this.errorMessage != null) {
          console.log(this.errorMessage);
          alert("Error en la petición");
        }
      }
    );


  }

}
