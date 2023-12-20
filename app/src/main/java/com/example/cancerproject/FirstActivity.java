package com.example.cancerproject;

import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.view.animation.Animation;
import android.view.animation.AnimationUtils;

import com.example.cancerproject.adapter.FirstActivityAdapter;
import com.example.cancerproject.model.FirstActivityModel;

import org.tensorflow.lite.support.label.Category;

import java.util.ArrayList;
import java.util.List;
import java.util.Locale;

public class FirstActivity extends AppCompatActivity {
RecyclerView orderRecycler;
FirstActivityAdapter OrderAdapter;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.first_activity);

        List<FirstActivityModel>  orderList = new ArrayList<>();
        orderList.add (new FirstActivityModel(1, "doctor", "Advices", "For an accurate result, read the advices","arrow" ));
        orderList.add (new FirstActivityModel(2, "light_of", "Advice №1", "Take photos in a well-lit room","arrow" ));
        orderList.add (new FirstActivityModel(3, "phone", "Advice №2", "Take photos with the flash, the photo quality will be better","arrow" ));
        orderList.add (new FirstActivityModel(4, "mole", "Advice №3", "Try to have only 1 mole in the photo.","arrow" ));
        orderList.add (new FirstActivityModel(5, "justt", "Advice №3", "Take photos close","" ));
        setCategoryRecycler(orderList);
    }
    //переход на главную стриницу
    public void onMainPage(View v){
        final Animation animAlpha = AnimationUtils.loadAnimation(this, R.anim.alpha);
        v.startAnimation(animAlpha);

        Intent intent = new Intent(this, MainActivity.class);
        startActivity(intent);
    }
    private void setCategoryRecycler (List<FirstActivityModel> firstactivityorder){
        RecyclerView.LayoutManager layoutManager=new LinearLayoutManager(this, RecyclerView.HORIZONTAL, false);

        orderRecycler = findViewById(R.id.orderRecycler);
        orderRecycler.setLayoutManager(layoutManager);

        OrderAdapter = new FirstActivityAdapter(this, firstactivityorder );
        orderRecycler.setAdapter(OrderAdapter);


    }
}