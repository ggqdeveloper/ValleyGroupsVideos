import {Injectable} from "@angular/core";
import {HttpClient, HttpResponse, HttpHeaders} from "@angular/common/http";
import {Observable} from "rxjs";
import {GLOBAL} from "./global";

@Injectable()

export class UserService {
  public url: string;
  public identity;
  public token;

  constructor(public _http: HttpClient) {
    this.url = GLOBAL.url;
  }

  registerUser(user): Observable<any> {
    let json = JSON.stringify(user);
    let params = "json=" + json;
    let headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');

    return this._http.post(this.url + "api/register", params, {headers});
  }

  editUser(user): Observable<any> {
    let json = JSON.stringify(user);
    let params = "json=" + json;
    let headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');

    return this._http.post(this.url + "api/user/edit", params, {headers});
  }
}
