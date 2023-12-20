package com.example.cancerproject;

import androidx.annotation.Nullable;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.AppCompatButton;

import android.Manifest;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.graphics.Bitmap;
import android.media.ThumbnailUtils;
import android.net.Uri;
import android.os.Bundle;
import android.provider.MediaStore;
import android.util.Log;
import android.view.View;
import android.view.animation.Animation;
import android.view.animation.AnimationUtils;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.TextView;


import com.example.cancerproject.ml.Model;
//import com.example.cancerproject.ml.EfficientNetB4;
//import com.example.cancerproject.ml.Model;
//import com.example.cancerproject.ml.Model5176;

import org.tensorflow.lite.DataType;
import org.tensorflow.lite.support.tensorbuffer.TensorBuffer;

import java.io.FileWriter;
import java.io.IOException;
import java.nio.ByteBuffer;
import java.nio.ByteOrder;



public class MainActivity extends AppCompatActivity {
    final static String nameVariableKey = "NAME_VARIABLE";
    String textname_result = "undefined";
    Button camera, gallery, analys;
    ImageView imageView;
    TextView result;
//    int imageSize = 32;
    int imageSize =299;

    @Override
    protected void onCreate(Bundle savedInstanceState) {

            super.onCreate(savedInstanceState);
            setContentView(R.layout.activity_main);

            camera = (AppCompatButton) findViewById(R.id.camera);
            gallery = findViewById(R.id.gallery);
            result = findViewById(R.id.textView4);
            imageView = findViewById(R.id.imageView);


            //анимация кнопок
            final Animation animAlpha = AnimationUtils.loadAnimation(this, R.anim.alpha);

//            analys.setOnClickListener(new Button.OnClickListener(){
//            @Override
//            public void onClick(View view) {
//                view.startAnimation(animAlpha);
//
//
//            }
//            });


//        if (savedInstanceState != null) {
//            // Restore value of members from saved state and populare your RecyclerView again
//            result = savedInstanceState.getString("res");
//
//        }
            camera.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View view) {
                    view.startAnimation(animAlpha);
                    if (checkSelfPermission(Manifest.permission.CAMERA) == PackageManager.PERMISSION_GRANTED) {
                        Intent cameraIntent = new Intent(MediaStore.ACTION_IMAGE_CAPTURE);
                        startActivityForResult(cameraIntent, 3);
                    } else {
                        requestPermissions(new String[]{Manifest.permission.CAMERA}, 100);
                    }
                }
            });

            gallery.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View view) {
                    view.startAnimation(animAlpha);

                    Intent cameraIntent = new Intent(Intent.ACTION_PICK, MediaStore.Images.Media.EXTERNAL_CONTENT_URI);
                    startActivityForResult(cameraIntent, 1);
                }

            });
        }
    //переход на следующую страницу
    public void onClickSecondPage(View v){
        final Animation animAlpha = AnimationUtils.loadAnimation(this, R.anim.alpha);
        v.startAnimation(animAlpha);

        Intent intent = new Intent(this, SecondActiviry.class);
        intent.putExtra("res", result.getText().toString());
        startActivity(intent);
    }

    //переход на  страницу с советами
    public void onClickStart(View v){
        final Animation animAlpha = AnimationUtils.loadAnimation(this, R.anim.alpha);
        v.startAnimation(animAlpha);

        Intent intent = new Intent(this, FirstActivity.class);
        startActivity(intent);
    }

    public void saveName(View view) {

        // получаем введенное имя

        //  сохраняем его в переменную name
        textname_result = result.getText().toString();
    }
    public void getName(View view) {

        //  выводим сохраненное имя
        result.setText(textname_result);
    }
    @Override
    protected void onSaveInstanceState(Bundle outState) {
        TextView result = (TextView)findViewById(R.id.textView4);
        outState.putString("key", result.getText().toString());
//        outState.putString("key", textname_result);
        super.onSaveInstanceState(outState);
    }
    // получение ранее сохраненного состояния
    @Override
    protected void onRestoreInstanceState(Bundle savedInstanceState) {
        super.onRestoreInstanceState(savedInstanceState);

        textname_result = savedInstanceState.getString("key");
        result.setText(textname_result);
    }
        public void classifyImage (Bitmap image){
            try {
                // input
                Model model = Model.newInstance(getApplicationContext());
//                EfficientNetB4 model = EfficientNetB4.newInstance(getApplicationContext());
                // Creates inputs for reference.
                TensorBuffer inputFeature0 = TensorBuffer.createFixedSize(new int[]{1, 299, 299, 3}, DataType.FLOAT32);
                ByteBuffer byteBuffer = ByteBuffer.allocateDirect(4 * imageSize * imageSize * 3);
                byteBuffer.order(ByteOrder.nativeOrder());
                int[] intValues = new int[imageSize * imageSize];
                image.getPixels(intValues, 0, image.getWidth(), 0, 0, image.getWidth(), image.getHeight());
                int pixel = 0;
                //iterate over each pixel and extract R, G, and B values. Add those values individually to the byte buffer.
                for (int i = 0; i < imageSize; i++) {
                    for (int j = 0; j < imageSize; j++) {
                        int val = intValues[pixel++]; // RGB
                        byteBuffer.putFloat(((val >> 16) & 0xFF) * (1.f / 255));
                        byteBuffer.putFloat(((val >> 8) & 0xFF) * (1.f / 255));
                        byteBuffer.putFloat((val & 0xFF) * (1.f / 255));
                    }
                }

                //в bitmap
                inputFeature0.loadBuffer(byteBuffer);
                // Runs model inference and gets result.
                Model.Outputs outputs = model.process(inputFeature0);
//                EfficientNetB4.Outputs outputs = model.process(inputFeature0);
                TensorBuffer outputFeature0 = outputs.getOutputFeature0AsTensorBuffer();
                // output
                float[] confidences = outputFeature0.getFloatArray();
                // find the index of the class with the biggest confidence.
                int maxPos = 0;
                float maxConfidence = 0;
                for (int i = 0; i < confidences.length; i++) {
                    if (confidences[i] > maxConfidence) {
                        maxConfidence = confidences[i];
                        maxPos = i;
                    }
                }
                String[] classes = {"Actinic keratosis", "Basal cell carcinoma", "Benign keratoses", "Dermatofibroma",
                        "Melanoma", "Melanocytic nevus", "Squamous cell carcinoma", "Not recognized", "Vascular lesions"};

                result.setText(classes[maxPos]);

                // Releases model resources if no longer used.
                model.close();
            } catch (IOException e) {
                // TODO Handle the exception
            }
        }

        @Override
        protected void onActivityResult ( int requestCode, int resultCode, @Nullable Intent data){
            if (resultCode == RESULT_OK) {
                if (requestCode == 3) {
                    Bitmap image = (Bitmap) data.getExtras().get("data");
                    int dimension = Math.min(image.getWidth(), image.getHeight());
                    image = ThumbnailUtils.extractThumbnail(image, dimension, dimension);
                    imageView.setImageBitmap(image);

                    image = Bitmap.createScaledBitmap(image, imageSize, imageSize, false);
                    classifyImage(image);
                } else {
                    Uri dat = data.getData();
                    Bitmap image = null;
                    try {
                        image = MediaStore.Images.Media.getBitmap(this.getContentResolver(), dat);
                    } catch (IOException e) {
                        e.printStackTrace();
                    }
                    int dimension = Math.min(image.getWidth(), image.getHeight());
                    image = ThumbnailUtils.extractThumbnail(image, dimension, dimension);
                    imageView.setImageBitmap(image);

                    image = Bitmap.createScaledBitmap(image, imageSize, imageSize, false);
                    classifyImage(image);
                }
            }
            super.onActivityResult(requestCode, resultCode, data);
        }


    }

