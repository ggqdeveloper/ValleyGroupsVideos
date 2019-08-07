export class Video {
  constructor(
    public id: number,
    public user_id,
    public title: string,
    public description: any,
    public image: string,
    public path: string,
    public status: string
  ) {
  }
}
