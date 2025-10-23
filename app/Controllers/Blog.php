<?php

namespace App\Controllers;
use App\Models\Blog_model;

class Blog extends BaseController
{
    var $blog_model;
    function __construct(){
        $this->blog_model = new Blog_model();
    }
    public function index()
    {
        $data = $this->data;
        $data['pageTitle'] = 'Blog';
        $data['active_menu'] = 'blog';
        $data['blog_posts'] = $this->blog_model->get_blog();
        return view('view_blog', $data);
    }

    public function blog_detail($url = '')
    {
        $data = $this->data;
        $data['pageTitle'] = 'Blog';
        $getData = $this->request->getGet();
        $blogPosts = [
            1 => [
                'title' => 'Complete Guide to Solar Panel Installation in Jaipur 2024',
                'content' => '
                <p class="lead">Installing solar panels in Jaipur has never been more accessible, thanks to government initiatives and decreasing costs. This comprehensive guide covers everything you need to know about going solar in the Pink City.</p>
                
                <h3>Why Choose Solar in Jaipur?</h3>
                <p>Jaipur receives excellent solar irradiation throughout the year, making it one of the best cities in India for solar energy generation. With over 300 sunny days annually, your solar investment will pay off faster than in most other cities.</p>
                
                <img src="assets/images/download.jpg" class="img-fluid rounded my-4" alt="Solar Installation Process">
                
                <h3>Step-by-Step Installation Process</h3>
                <ol>
                    <li><strong>Site Assessment:</strong> Our experts visit your location to assess roof condition, shading, and electrical infrastructure.</li>
                    <li><strong>System Design:</strong> We create a customized solar system design based on your energy consumption and roof space.</li>
                    <li><strong>Permits & Approvals:</strong> We handle all government approvals and net metering applications.</li>
                    <li><strong>Installation:</strong> Professional installation typically takes 1-2 days for residential systems.</li>
                    <li><strong>Commissioning:</strong> System testing and grid connection to start generating clean energy.</li>
                </ol>
                
                <div class="alert alert-info">
                    <h5>💡 Pro Tip</h5>
                    <p class="mb-0">The best time to install solar panels in Jaipur is during the post-monsoon period (October to February) for optimal installation conditions.</p>
                </div>
                
                <h3>Cost Breakdown and Government Benefits</h3>
                <p>The cost of solar installation in Jaipur varies based on system size and component quality. Here\'s what you can expect:</p>
                
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>System Size</th>
                            <th>Cost (Before Subsidy)</th>
                            <th>Government Subsidy</th>
                            <th>Final Cost</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>3 kW</td>
                            <td>₹1,95,000</td>
                            <td>₹54,000</td>
                            <td>₹1,41,000</td>
                        </tr>
                        <tr>
                            <td>5 kW</td>
                            <td>₹3,25,000</td>
                            <td>₹78,000</td>
                            <td>₹2,47,000</td>
                        </tr>
                        <tr>
                            <td>10 kW</td>
                            <td>₹6,50,000</td>
                            <td>₹78,000</td>
                            <td>₹5,72,000</td>
                        </tr>
                    </tbody>
                </table>
                
                <h3>Maintenance and Performance</h3>
                <p>Solar panels require minimal maintenance in Jaipur\'s climate. Regular cleaning during dust storm seasons and annual professional inspections ensure optimal performance for 25+ years.</p>
                
                <blockquote class="blockquote text-center my-4">
                    <p class="mb-0">"Our 5kW solar system has reduced our electricity bill from ₹4,500 to just ₹600 per month. Best investment we\'ve made!"</p>
                    <footer class="blockquote-footer mt-2">Rajesh Sharma, <cite title="Source Title">Malviya Nagar</cite></footer>
                </blockquote>
                
                <h3>Next Steps</h3>
                <p>Ready to start your solar journey? Contact our team for a free consultation and personalized quote. We\'ll assess your property and provide detailed savings calculations specific to your energy usage.</p>
            ',
                'author' => 'Solar Expert Team',
                'date' => 'January 15, 2024',
                'category' => 'Installation Guide',
                'image' => 'assets/images/download (1).jpg'
            ],
            2 => [
                'title' => 'How to Get ₹78,000 Solar Subsidy in Rajasthan',
                'content' => '
                <p class="lead">The Government of India offers substantial subsidies for rooftop solar installations. Here\'s your complete guide to claiming up to ₹78,000 in solar subsidies in Rajasthan.</p>
                
                <h3>Eligibility Criteria</h3>
                <ul>
                    <li>Residential consumers of JVVNL, AVVNL, or JdVVNL</li>
                    <li>Own roof or legal right to install solar panels</li>
                    <li>Adequate roof space without shading</li>
                    <li>Proper electrical infrastructure</li>
                </ul>
                
                <h3>Subsidy Amount Structure</h3>
                <p>The subsidy is provided as per the following structure:</p>
                <ul>
                    <li><strong>First 3 kW:</strong> ₹18,000 per kW</li>
                    <li><strong>Beyond 3 kW up to 10 kW:</strong> ₹9,000 per kW</li>
                    <li><strong>Maximum subsidy:</strong> ₹78,000 per household</li>
                </ul>
                
                <div class="alert alert-success">
                    <h5>✅ Important Note</h5>
                    <p class="mb-0">The subsidy is transferred directly to your bank account after successful installation and inspection through DBT (Direct Benefit Transfer).</p>
                </div>
                
                <h3>Required Documents</h3>
                <ol>
                    <li>Electricity bill copy</li>
                    <li>Aadhaar card</li>
                    <li>Bank account details</li>
                    <li>Property ownership documents</li>
                    <li>Passport size photographs</li>
                </ol>
            ',
                'author' => 'Policy Expert',
                'date' => 'January 10, 2024',
                'category' => 'Government Policy',
                'image' => 'assets/images/download (2).jpg'
            ],
            // Add more blog posts as needed
        ];
        $postId = isset($getData['id']) ? intval($getData['id']) : 1;
        $data['post'] = $this->blog_model->get_blog('',$url);
        $data['active_menu'] = 'blog';
        return view('view_blog_detail', $data);
    }
}