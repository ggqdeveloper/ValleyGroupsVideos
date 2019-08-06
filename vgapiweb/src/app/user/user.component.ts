import {Component, OnInit} from '@angular/core';
import {ActivatedRoute, Router} from "@angular/router";
import {LoginService} from "../services/login.service";
import {UserService} from "../services/user.service";
import {User} from "../models/user";

@Component({
  selector: 'app-user',
  templateUrl: './user.component.html',
  styleUrls: ['./user.component.sass'],
  providers: [LoginService, UserService]
})
export class UserComponent implements OnInit {

  public title = "Edit User";
  public user: User;
  public errorMessage;
  public idUserEdit;
  public identity;
  public loading;

  constructor(
    private _loginService: LoginService,
    private _userService: UserService,
    private _route: ActivatedRoute,
    private _router: Router
  ) {
    this.idUserEdit = 2;
    this.identity = this._loginService.getIdentity();
    this.user = new User(this.identity.id, 'USER', this.identity.name, this.identity.surname, this.identity.email, null, null);
  }

  ngOnInit() {
  }

  onSubmit() {
    this._route.params.subscribe(params => {

      this.loading = "show";
      this._userService.editUser(this.user).subscribe(
        response => {
          this.user = response.data;
          this.loading = 'hide';
          this.idUserEdit = 1;
        },
        error => {
          this.errorMessage = <any>error;
          this.idUserEdit = 0;

          if (this.errorMessage != null) {
            console.log(this.errorMessage);
            alert("Error en la petición");
          }
        }
      );

    });
  }

}
