import {Component, OnInit} from '@angular/core';
import {ActivatedRoute, Router} from "@angular/router";
import {User} from "../models/user";
import {UserService} from "../services/user.service";

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.sass'],
  providers: [UserService]
})
export class RegisterComponent implements OnInit {

  public title = 'Register';
  public errorMessage;
  public idRegister;
  public user: User;

  constructor(
    private _userService: UserService,
    private _router: Router
  ) {
    this.idRegister = 2;
    this.user = new User(null, 'USER', null, null, null, null, null);
  }

  ngOnInit() {
  }

  onSubmit() {
    this._userService.registerUser(this.user).subscribe(
      response => {
        this._router.navigate(["/default"]);
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
