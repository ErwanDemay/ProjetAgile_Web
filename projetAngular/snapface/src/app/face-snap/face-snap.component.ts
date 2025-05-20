import {
  DatePipe,
  DecimalPipe,
  NgClass,
  NgStyle,
  UpperCasePipe,
} from '@angular/common';
import { Component, Input, OnInit } from '@angular/core';
import { FaceSnap } from '../models/face-snap';

@Component({
  selector: 'app-face-snap',
  standalone: true,
  imports: [NgStyle, NgClass, UpperCasePipe, DatePipe, DecimalPipe],
  templateUrl: './face-snap.component.html',
  styleUrl: './face-snap.component.scss',
})
export class FaceSnapComponent implements OnInit {
  @Input() FaceSnap!: FaceSnap;

  snapButtonText!: string;
  userHasSnapped!: boolean;
  largeNumber: number = 4667196.76;

  ngOnInit(): void {
    'https://cdn.pixabay.com/photo/2015/05/31/16/03/teddy-bear-792273_1280.jpg';
    this.snapButtonText = 'Oh Snap!';
    this.userHasSnapped = false;
  }

  onSnap(): void {
    if (this.userHasSnapped) {
      this.unSnap();
    } else {
      this.snap();
    }
  }

  unSnap(): void {
    this.snapButtonText = 'Oh Snap!';
    this.FaceSnap.removeSnap();
    this.userHasSnapped = false;
  }

  snap(): void {
    this.snapButtonText = 'OOPS, unSnapped!';
    this.FaceSnap.addSnap();
    this.userHasSnapped = true;
  }
}
