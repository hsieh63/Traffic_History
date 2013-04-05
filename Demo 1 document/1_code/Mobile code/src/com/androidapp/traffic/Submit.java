package com.androidapp.traffic;

import android.app.Activity;
import android.os.Bundle;
import android.view.View;
import android.widget.RadioButton;
import android.widget.TextView;

public class Submit extends Activity
{
	
	RadioButton rb0;
	RadioButton rb1;
	RadioButton rb2;
	RadioButton rb3;
	RadioButton rb4;
	
	TextView tv;
	
	
	@Override
    public void onCreate(Bundle savedInstanceState) 
	{
        super.onCreate(savedInstanceState);
        setContentView(R.layout.submit);
        
        rb0 = (RadioButton) findViewById(R.id.radio0);
        rb1 = (RadioButton) findViewById(R.id.radio1);
        rb2 = (RadioButton) findViewById(R.id.radio2);
        rb3 = (RadioButton) findViewById(R.id.radio3);
        rb4 = (RadioButton) findViewById(R.id.radio4);
        
        tv = (TextView) findViewById(R.id.stv);
    }
	
	
	public void submit(View v)
	{
		
	    boolean a = rb0.isChecked();
	    boolean b = rb1.isChecked();
	    boolean c = rb2.isChecked();
	    boolean d = rb3.isChecked();
	    boolean e = rb4.isChecked();
	    
	    if(a==true)
	    {
	    	tv.setText("1");
	    }
	    else if(b==true)
	    {
	    	tv.setText("2");
	    }
	    else if(c==true)
	    {
	    	tv.setText("3");
	    }
	    else if(d==true)
	    {
	    	tv.setText("4");
	    }
	    else if(e==true)
	    {
	    	tv.setText("5");
	    }
	    else 
	    {
	    	tv.setText("1");
	    }
	    
	    
	    
		
		
	}

	
	

}
