import {Injectable} from "@angular/core";
import {HttpClient, HttpResponse, HttpHeaders} from "@angular/common/http";
import {Observable} from "rxjs";
import {GLOBAL} from "./global";

@Injectable()

export class LoginService {
  public url: string;
  public identity;
  public token;

  constructor(public _http: HttpClient) {
    this.url = GLOBAL.url;
  }

  signup(user_to_login) {
    let json = JSON.stringify(user_to_login);
    let params = "json=" + json;
    let headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');

    return this._http.post(this.url + "api/login", params, {headers});
  }

  getIdentity() {
    let identity = JSON.parse(localStorage.getItem('identity'));

    if (identity != "undefined") {
      this.identity = identity;
    } else {
      this.identity = null;
    }

    return this.identity;
  }

  getToken() {
    let token = localStorage.getItem('token');

    if (token != "undefined") {
      this.token = token;
    } else {
      this.token = null;
    }

    return this.token;
  }
}
