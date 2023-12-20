package com.example.cancerproject;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.view.animation.Animation;
import android.view.animation.AnimationUtils;

public class Start extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_start);
    }
    //переход на следующую страницу
    public void onClickMain(View v){
        final Animation animAlpha = AnimationUtils.loadAnimation(this, R.anim.alpha);
        v.startAnimation(animAlpha);

        Intent intent = new Intent(this, FirstActivity.class);
        startActivity(intent);
    }
}