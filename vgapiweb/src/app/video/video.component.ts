import {Component, OnInit} from '@angular/core';
import {ActivatedRoute, Router} from "@angular/router";
import {LoginService} from "../services/login.service";
import {VideoService} from "../services/video.service";
import {Video} from "../models/video";

@Component({
  selector: 'app-video',
  templateUrl: './video.component.html',
  styleUrls: ['./video.component.sass'],
  providers: [LoginService, VideoService]
})

export class VideoComponent implements OnInit {

  public title = 'Crear video';
  public video1: Video;
  public errorMessage;
  public idVideoCreated;
  public identity;
  public token;
  public loading;

  constructor(
    private _loginService: LoginService,
    private _videoService: VideoService,
    private _route: ActivatedRoute,
    private _router: Router
  ) {
    this.idVideoCreated = 2;
    this.identity = this._loginService.getIdentity();
    this.video1 = new Video(null, this.identity.sub, "", "", "", "", 'ACTIVO');
  }

  ngOnInit() {
  }

  onSubmit() {
    this._route.params.subscribe(params => {

      this.loading = "show";
      let token = this._loginService.getToken();
      this._videoService.videoCreated(token, this.video1).subscribe(
        response => {
          console.log(response);
          this.loading = 'hide';
          this.idVideoCreated = 1;
        },
        error => {
          this.errorMessage = <any>error;
          this.idVideoCreated = 0;

          if (this.errorMessage != null) {
            console.log(this.errorMessage);
            alert("Error en la petición");
          }
        }
      );

    });
  }

}
