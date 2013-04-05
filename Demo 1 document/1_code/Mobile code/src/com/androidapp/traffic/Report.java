package com.androidapp.traffic;

import java.io.IOException;
import java.io.InputStream;
import java.net.MalformedURLException;
import java.net.URL;
import java.util.ArrayList;
import java.util.List;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.HttpClient;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;

import android.app.Activity;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.net.http.AndroidHttpClient;
import android.os.AsyncTask;
import android.os.Bundle;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.Spinner;

public class Report extends Activity
{
	
	
	
	Spinner sp2;
	ImageView iv;
	
	
	String str3="";
	
	
	@Override
    public void onCreate(Bundle savedInstanceState) 
	{
        super.onCreate(savedInstanceState);
        setContentView(R.layout.report);
        
        
        
      
        sp2 = (Spinner) findViewById(R.id.spinner2);
        iv = (ImageView) findViewById(R.id.imageView1);
      
        
        
        
        ArrayAdapter<CharSequence> adapter2 = ArrayAdapter.createFromResource(this,
                R.array.timearray, android.R.layout.simple_spinner_item);
        adapter2.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        sp2.setAdapter(adapter2);
        
        iv.setImageResource(android.R.color.transparent);
        
        
        
        
        
        
    }
	
	//getImage runs network connections on a separate thread to appease Android
	class getImage extends AsyncTask<String, Void, String> {

	    private Exception exception;

	    protected String doInBackground(String... urls) {
	    	//Zip code
	    	final EditText nameField = (EditText) findViewById(R.id.editText1);  
	        String zipcode = nameField.getText().toString(); 
	        
	        //Time
	        final Spinner feedbackSpinner = (Spinner) findViewById(R.id.spinner2);  
	        String time = feedbackSpinner.getSelectedItem().toString();
	        
	    	
	        // Create a new HttpClient and Post Header
	        HttpClient httpclient = AndroidHttpClient.newInstance("Android");
	        HttpPost httppost = new HttpPost("http://traffichistory.co.nf/mapImaging.php");
	        
	        //key pairs match up with server script to send & receive data

	        try {
	            // Add your data
	            List<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>(2);
	            nameValuePairs.add(new BasicNameValuePair("zipcode", zipcode));
	            nameValuePairs.add(new BasicNameValuePair("time", time));
	            httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));

	            // Execute HTTP Post Request
	            HttpResponse response = httpclient.execute(httppost);
	            HttpEntity result = response.getEntity();
	            
	            //get the message data as a bytestream and convert to string to parse URL
	            
	            InputStream is = result.getContent();
	       
	            byte[] data = new byte[256];

	            StringBuffer buffer = new StringBuffer();
	            int len = 0;
	           
	            while (-1 != (len = is.read(data))) {
	                    buffer.append(new String(data, 0, len));
	            }

	            is.close();
	            
	            String str = buffer.toString();
	            
	            String str2 = str.substring(24);
	            
	            int temp = str2.indexOf("'");
	            
	            str3 = str2.substring(0,temp);
	            
	            
	      
	        } catch (ClientProtocolException e) {
	            // TODO Auto-generated catch block
	        } catch (IOException e) {
	            // TODO Auto-generated catch block
	        }
			return null;
	    }

	    protected void onPostExecute(String url) {
	        // TODO: check this.exception 
	        // TODO: do something with the feed
	    }
	 }
	

	

	





//currently called when user presses button to obtain report
//runs a separate thread to handle network communication
public void postData(View v) 
{
	
	/*
	//Zip code
	final EditText nameField = (EditText) findViewById(R.id.editText1);  
    String zipcode = nameField.getText().toString(); 
    
    //Time
    final Spinner feedbackSpinner = (Spinner) findViewById(R.id.spinner2);  
    String time = feedbackSpinner.getSelectedItem().toString();
    
	
    // Create a new HttpClient and Post Header
    HttpClient httpclient = new DefaultHttpClient();
    HttpPost httppost = new HttpPost("http://traffichistory.co.nf/mapImaging.php");

    try {
        // Add your data
        List<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>(2);
        nameValuePairs.add(new BasicNameValuePair("zipcode", zipcode));
        nameValuePairs.add(new BasicNameValuePair("time", time));
        httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));

        // Execute HTTP Post Request
        HttpResponse response = httpclient.execute(httppost);
        HttpEntity result = response.getEntity();
        
        InputStream is = result.getContent();
   
        byte[] data = new byte[256];

        StringBuffer buffer = new StringBuffer();
        int len = 0;
       
        while (-1 != (len = is.read(data))) {
                buffer.append(new String(data, 0, len));
        }

        is.close();
        
        String str = buffer.toString();
        
        String str2 = str.substring(24);
        
        int temp = str2.indexOf("'");
        
        String str3 = str2.substring(0,temp);
        
    */

	String s1="";
	new getImage().execute(s1,null,str3); //call getImage to update str3 to image URL
	
        //from the image URL, obtain the image and set it to display on the ImageView
        try {
        	  ImageView i = (ImageView)findViewById(R.id.imageView1);
        	  Bitmap bitmap = BitmapFactory.decodeStream((InputStream)new URL(str3).getContent());
        	  i.setImageBitmap(bitmap); 
        	} catch (MalformedURLException e) {
        	  e.printStackTrace();
        	} catch (IOException e) {
        	  e.printStackTrace();
        	}
        
      
        
        /*
        
    } catch (ClientProtocolException e) {
        // TODO Auto-generated catch block
    } catch (IOException e) {
        // TODO Auto-generated catch block
    }
    */
	
    
} 


//postData2 was an attempt to run the entire image get & set process in a separate thread
public void postData2(View v){
	
	class getImage extends AsyncTask<String, Void, String> {

	    private Exception exception;

	    protected String doInBackground(String... urls) {
	    	//Zip code
	    	final EditText nameField = (EditText) findViewById(R.id.editText1);  
	        String zipcode = nameField.getText().toString(); 
	        
	        //Time
	        final Spinner feedbackSpinner = (Spinner) findViewById(R.id.spinner2);  
	        String time = feedbackSpinner.getSelectedItem().toString();
	        
	    	
	        // Create a new HttpClient and Post Header
	        HttpClient httpclient = new DefaultHttpClient();
	        HttpPost httppost = new HttpPost("http://traffichistory.co.nf/mapImaging.php");
	        

	        try {
	            // Add your data
	            List<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>(2);
	            nameValuePairs.add(new BasicNameValuePair("zipcode", zipcode));
	            nameValuePairs.add(new BasicNameValuePair("time", time));
	            httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));

	            // Execute HTTP Post Request
	            HttpResponse response = httpclient.execute(httppost);
	            HttpEntity result = response.getEntity();
	            
	            InputStream is = result.getContent();
	       
	            byte[] data = new byte[256];

	            StringBuffer buffer = new StringBuffer();
	            int len = 0;
	           
	            while (-1 != (len = is.read(data))) {
	                    buffer.append(new String(data, 0, len));
	            }

	            is.close();
	            
	            String str = buffer.toString();
	            
	            String str2 = str.substring(24);
	            
	            int temp = str2.indexOf("'");
	            
	            str3 = str2.substring(0,temp);
	            
	            try {
	          	  ImageView i = (ImageView)findViewById(R.id.imageView1);
	          	  Bitmap bitmap = BitmapFactory.decodeStream((InputStream)new URL(str3).getContent());
	          	  i.setImageBitmap(bitmap); 
	          	} catch (MalformedURLException e) {
	          	  e.printStackTrace();
	          	} catch (IOException e) {
	          	  e.printStackTrace();
	          	}
	            
	      
	        } catch (ClientProtocolException e) {
	            // TODO Auto-generated catch block
	        } catch (IOException e) {
	            // TODO Auto-generated catch block
	        }
			return null;
	    }

	    protected void onPostExecute(String url) {
	        // TODO: check this.exception 
	        // TODO: do something with the feed
	    }
	 }
	
}





}
