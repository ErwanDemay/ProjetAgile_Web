import { Component, OnInit } from '@angular/core';
import { FaceSnapComponent } from './face-snap/face-snap.component';
import { FaceSnap } from './models/face-snap';

@Component({
  selector: 'app-root',
  imports: [FaceSnapComponent],
  templateUrl: './app.component.html',
  styleUrl: './app.component.scss',
})
export class AppComponent implements OnInit {
  faceSnaps!: FaceSnap[];

  ngOnInit(): void {
    this.faceSnaps = [
      new FaceSnap(
        'Face Snap #1',
        'This is a face snap',
        'https://cdn.pixabay.com/photo/2015/05/31/16/03/teddy-bear-792273_1280.jpg',
        new Date(),
        200
      ),
      new FaceSnap(
        'Three rock moutain',
        'un endroit magnifique pour les randonnées',
        'https://cdn.pixabay.com/photo/2015/05/31/16/03/teddy-bear-792273_1280.jpg',
        new Date(),
        3
      ),
      new FaceSnap(
        'Face Snap #4',
        'This is a face snap',
        'https://cdn.pixabay.com/photo/2015/05/31/16/03/teddy-bear-792273_1280.jpg',
        new Date(),
        1
      ),
    ];
    this.faceSnaps[1].setLocation('Paris');
  }
}
