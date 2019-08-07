import {Injectable} from "@angular/core";
import {HttpClient, HttpResponse, HttpHeaders} from "@angular/common/http";
import "rxjs/add/operator/map";
import {Observable} from "rxjs/Observable";
import {GLOBAL} from "./global";

@Injectable()
export class VideoService {
  public url: string;
  public identity;
  public token;

  constructor(private _http: HttpClient) {
    this.url = GLOBAL.url;
  }

  getVideos(): Observable<any> {
    let headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');

    return this._http.get(this.url + "api/videos");
  }

  videoCreated(token, video): Observable<any> {
    let json = JSON.stringify(video);
    let params = "json=" + json + "&authorization=" + token;
    let headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');

    return this._http.post(this.url + "api/videos", params, {headers});
  }

  deleteVideos(token, id): Observable<any> {
    let headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded').set('authorization', token);

    return this._http.delete(this.url + "api/videos/" + id, {headers});
  }

}
