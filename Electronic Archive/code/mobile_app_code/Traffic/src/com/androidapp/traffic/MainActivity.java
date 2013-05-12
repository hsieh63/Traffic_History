package com.androidapp.traffic;

import android.app.Activity;
import android.content.Intent;
import android.graphics.Typeface;
import android.os.Bundle;
import android.view.Menu;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.TextView;

public class MainActivity extends Activity {
	
	

    @Override
    public void onCreate(Bundle savedInstanceState) 
    {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        
        Button main1 = (Button) findViewById(R.id.button1);
        Button main2 = (Button) findViewById(R.id.Button01);
        TextView tv = (TextView) findViewById(R.id.textView1);
        
        Typeface clouds = Typeface.createFromAsset(getAssets(), "contm.ttf");
        
        
        tv.setTypeface(clouds);
        main1.setTypeface(clouds);
        main2.setTypeface(clouds);
      
    	
    	main1.setOnClickListener(new OnClickListener()
        { 
        //On Click function
        public void onClick(View v) 
        {    	
        	Intent it = new Intent(MainActivity.this,Report.class);
            startActivity(it);     
              
        }
            
        });
    	
    	main2.setOnClickListener(new OnClickListener()
        { 
        //On Click function
        public void onClick(View v) 
        {    	
        	Intent it = new Intent(MainActivity.this,Submit.class);
            startActivity(it);     
              
        }
            
        });
        
        
        
        
        
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.activity_main, menu);
        return true;
    }
}
