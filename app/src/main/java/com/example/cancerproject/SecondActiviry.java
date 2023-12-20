package com.example.cancerproject;

import android.content.ClipData;
import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
//import android.text.ClipboardManager;
import android.content.ClipboardManager;
//	import android.content.ClipboardManager;
//import android.text.ClipboardManager.setPrimaryClip;
import android.view.View;
import android.webkit.JavascriptInterface;
import android.widget.Button;
import android.widget.ImageButton;
import android.widget.TextView;
import android.widget.Toast;


import androidx.appcompat.app.AppCompatActivity;

public class SecondActiviry extends AppCompatActivity {

    TextView result;
    TextView txt;
    Button button4;
    ImageButton btnCopy;
    ClipboardManager clipboardManager;
    ClipData clipData;

    @Override
    protected void onCreate(Bundle savedInstanceState) {

        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_second_activiry);

        result = findViewById(R.id.textView3);
        txt = findViewById(R.id.txt);
        button4 = findViewById(R.id.button4);
        btnCopy = findViewById(R.id.btnCopy);



        String txtName  = getIntent().getStringExtra("res");
        result.setText(txtName);


//        ClipboardManager myClipboard;
//        myClipboard = (ClipboardManager)getSystemService(CLIPBOARD_SERVICE);
//        ClipData myClip;

//        clipboardManager=(ClipboardManager)getSystemService(Context.CLIPBOARD_SERVICE);
//        ClipData clip = ClipData.newPlainText("simple text", txtName);
//        clipboardManager.setPrimaryClip(clip);
//        btnCopy.setOnClickListener(new View.OnClickListener() {
//
//            @Override
//            @JavascriptInterface
//            public void onClick(View view) {
//                String text = txtName;
//                clipData = ClipData.newPlainText("text",text);
//                clipboardManager.setPrimaryClip(clipData);
////                Toast.makeText(getApplicationContext(),"Result Copied",Toast.LENGTH_SHORT).show();
//            } });

//        myClip = ClipData.newPlainText("text", txtName);
//        myClipboard.setPrimaryClip(myClip);

        String monthString;
        switch (txtName) {
            case "Actinic keratosis":  monthString = "Recommendation: UV protection, cryosurgery, topical imiquimod, and 5-FU.";
                break;
            case "Basal cell carcinoma": monthString = "Basal cell carcinoma (BCC) is the most common malignancy and the incidence is rising. BCCs have low mortality but can cause significant morbidity primarily through local destruction. ";
                break;
            case "Benign keratoses": monthString = "Experts recommend the use of ointments, gels, emulsions with imiquimod, 5-fluorouracil, ingenol mebutate gel, urea, salicylic acid, topical retinoids, 3% diclofenac sodium in 2.5% hyaluronic acid.";
                break;
            case "Dermatofibroma": monthString = "Dermatofibromas are referred to as benign fibrous histiocytomas of the skin, superficial/cutaneous benign fibrous histiocytomas, or common fibrous histiocytoma.";
                    break;
            case "Melanoma": monthString = "The most important and potentially modifiable environmental risk factor for developing malignant melanoma is the exposure to ultraviolet (UV) rays because of their genotoxic effect. Artificial UV exposure may play a role in the development of melanoma.";
                break;
            case "Melanocytic nevus":  monthString = "Melanocytic nevus is a benign formation; experts recommend paying great attention to moles in order to eliminate risks and not miss the moment of degeneration.";
                break;
            case "Squamous cell carcinoma": monthString = "Experts recommend mole removal. Recommendations: limit exposure to sunlight, wear protective clothing, use sunscreen at least 30";
                break;
            case "Not recognized" : monthString = "Please take a better photo of the mole. Review the tips again";
                button4.setVisibility(View.VISIBLE);
                break;
            case "Vascular lesions" : monthString = "This is a benign formation. If a mole doesn't bother you, experts recommend simply not touching it. Please note that cosmetic creams or folk remedies, but they turn out to be useless and even dangerous";
                break;
            default: monthString = "";
                break;
        }
        txt.setText(monthString);
    }
//public void onClickCopy(View view){
//    ClipboardManager clipboardManager;
//    ClipData clipData;
//    clipboardManager=(ClipboardManager)getSystemService(CLIPBOARD_SERVICE);
//            clipData = ClipData.newPlainText("text", text);
//            clipboardManager.setPrimaryClip(clipData);
//
//            Toast.makeText(getApplicationContext(), "Text Copied ", Toast.LENGTH_SHORT).show();
//
//
//}

    public void onClickCopy(View view){
        String txtName  = getIntent().getStringExtra("res");
        clipboardManager=(ClipboardManager)getSystemService(Context.CLIPBOARD_SERVICE);
        ClipData clip = ClipData.newPlainText("simple text", txtName);
        clipboardManager.setPrimaryClip(clip);

//      String text = txtName;
//      clipData = ClipData.newPlainText("text",text);
//      clipboardManager.setPrimaryClip(clipData);
//               Toast.makeText(getApplicationContext(),"Result Copied",Toast.LENGTH_SHORT).show();

        }
    //переход на предыдущую  страницу MainActivity
    public void onClickMainPage(View v){
        Intent intent = new Intent(this, MainActivity.class);
        startActivity(intent);
    }

}