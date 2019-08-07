import {Component, OnInit} from '@angular/core';
import {Router, ActivatedRoute} from "@angular/router";
import {LoginService} from "../services/login.service";
import {VideoService} from "../services/video.service";

@Component({
  selector: 'app-default',
  templateUrl: './default.component.html',
  styleUrls: ['./default.component.sass'],
  providers: [LoginService, VideoService]
})
export class DefaultComponent implements OnInit {

  public title = 'YouVideos';
  public identity;
  public videos;
  public errorMessage;
  public status;
  public loading;
  public pages;
  public pagePrev = 1;
  public pageNext = 1;

  constructor(
    private _loginService: LoginService,
    private _videoService: VideoService,
    private _route: ActivatedRoute,
    private _router: Router
  ) {
  }

  ngOnInit() {
    this.loading = "show";

    this.identity = this._loginService.getIdentity();

    this.getAllVideos();
  }

  deleteVideo(id) {
    this.loading = "show";
    let token = this._loginService.getToken();
    this._videoService.deleteVideos(token, id).subscribe(
      response => {
        this._router.navigate['default'];
        this.loading = 'hide';
        this.getAllVideos();
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

  getAllVideos() {
    this._route.params.subscribe(params => {

      this.loading = "show";
      this._videoService.getVideos().subscribe(
        response => {
          this.videos = response.data;
          console.log(this.videos);
          this.loading = 'hide';
        },
        error => {
          this.errorMessage = <any>error;

          if (this.errorMessage != null) {
            console.log(this.errorMessage);
            alert("Error en la petición");
          }
        }
      );

    });
  }

}
