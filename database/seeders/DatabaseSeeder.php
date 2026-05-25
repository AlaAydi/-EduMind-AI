<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\QuizAttempt;
use App\Models\ChatMessage;
use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\CourseDocument;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Default Users
        $student = User::create([
            'name' => 'Alex Rivers',
            'email' => 'student@edumind.ai',
            'password' => Hash::make('password'),
            'role' => 'student',
            'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=150&q=80',
        ]);

        $teacher = User::create([
            'name' => 'Dr. Sarah Jenkins',
            'email' => 'teacher@edumind.ai',
            'password' => Hash::make('password'),
            'role' => 'teacher',
            'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=150&q=80',
        ]);

        $anotherStudent = User::create([
            'name' => 'Michael Chen',
            'email' => 'student2@edumind.ai',
            'password' => Hash::make('password'),
            'role' => 'student',
            'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=150&q=80',
        ]);

        $anotherTeacher = User::create([
            'name' => 'Prof. Marcus Vance',
            'email' => 'teacher2@edumind.ai',
            'password' => Hash::make('password'),
            'role' => 'teacher',
            'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=150&q=80',
        ]);

        // Extra students for stats
        for ($i = 1; $i <= 15; $i++) {
            User::create([
                'name' => 'Student ' . $i,
                'email' => 'student' . $i . '@example.com',
                'password' => Hash::make('password'),
                'role' => 'student',
                'avatar' => 'https://images.unsplash.com/photo-' . (1500000000000 + ($i * 1000000)) . '?auto=format&fit=crop&w=150&q=80',
            ]);
        }

        // 1.5 Create Categories
        $catAI = Category::create(['name' => 'Artificial Intelligence', 'slug' => 'artificial-intelligence']);
        $catWeb = Category::create(['name' => 'Web Development', 'slug' => 'web-development']);
        $catData = Category::create(['name' => 'Data Science', 'slug' => 'data-science']);
        $catDesign = Category::create(['name' => 'Design Systems', 'slug' => 'design-systems']);

        // 2. Create Courses
        $courses = [
            [
                'title' => 'Advanced Prompt Engineering & LLMs',
                'slug' => 'advanced-prompt-engineering-llms',
                'description' => 'Master the art of prompt design, system instructions, and chained operations to command models like Gemini, Claude, and GPT-4. Understand how temperature, top-k, and embeddings shape AI responses.',
                'level' => 'Beginner',
                'category_id' => $catAI->id,
                'duration' => '4h 15m',
                'thumbnail' => 'https://images.unsplash.com/photo-1677442136019-21780efad99a?auto=format&fit=crop&w=600&q=80',
                'teacher_id' => $teacher->id,
            ],
            [
                'title' => 'Mastering Laravel & Blade Component Design',
                'slug' => 'mastering-laravel-blade-component-design',
                'description' => 'Dive deep into Laravel\'s templating engine. Build scalable layout inheritance architectures, learn component caching, manage scoped data-binding, and craft visual component libraries using clean Tailwind CSS utilities.',
                'level' => 'Intermediate',
                'category_id' => $catWeb->id,
                'duration' => '6h 30m',
                'thumbnail' => 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?auto=format&fit=crop&w=600&q=80',
                'teacher_id' => $teacher->id,
            ],
            [
                'title' => 'Data Visualization with Python & ApexCharts',
                'slug' => 'data-visualization-python-apexcharts',
                'description' => 'Turn dry databases into gorgeous interactive, animated reports. Learn to extract patterns, preprocess datasets in Python, and feed cleaner JSON payloads directly into highly interactive dark-themed ApexCharts dashboards.',
                'level' => 'Intermediate',
                'category_id' => $catData->id,
                'duration' => '5h 45m',
                'thumbnail' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=600&q=80',
                'teacher_id' => $anotherTeacher->id,
            ],
            [
                'title' => 'Figma to Tailwind CSS Design Masterclass',
                'slug' => 'figma-tailwind-css-design-masterclass',
                'description' => 'Bridge the gap between design and implementation. Learn spacing systems, visual hierarchy, premium glassmorphic cards, custom animations, and layout grids to construct professional startups aesthetics from high-fidelity mockups.',
                'level' => 'Beginner',
                'category_id' => $catDesign->id,
                'duration' => '8h 15m',
                'thumbnail' => 'https://images.unsplash.com/photo-1541462608141-2ff030a64e43?auto=format&fit=crop&w=600&q=80',
                'teacher_id' => $anotherTeacher->id,
            ]
        ];

        $createdCourses = [];
        foreach ($courses as $c) {
            $createdCourses[] = Course::create($c);
        }

        // Add dummy documents to courses
        foreach($createdCourses as $c) {
            CourseDocument::create([
                'course_id' => $c->id,
                'title' => 'Course Syllabus & Setup Guide',
                'file_path' => '#',
                'type' => 'pdf'
            ]);
            CourseDocument::create([
                'course_id' => $c->id,
                'title' => 'Lecture 1 Video Recording',
                'file_path' => '#',
                'type' => 'video'
            ]);
        }

        // 3. Create Enrollments
        // Alex (our default student) enrollments
        Enrollment::create([
            'user_id' => $student->id,
            'course_id' => $createdCourses[0]->id, // Prompt Engineering
            'progress' => 85,
            'status' => 'active',
        ]);

        Enrollment::create([
            'user_id' => $student->id,
            'course_id' => $createdCourses[1]->id, // Laravel Blade
            'progress' => 40,
            'status' => 'active',
        ]);

        Enrollment::create([
            'user_id' => $student->id,
            'course_id' => $createdCourses[2]->id, // Data Viz
            'progress' => 100,
            'status' => 'completed',
        ]);

        // Michael Chen enrollments
        Enrollment::create([
            'user_id' => $anotherStudent->id,
            'course_id' => $createdCourses[0]->id,
            'progress' => 30,
            'status' => 'active',
        ]);
        Enrollment::create([
            'user_id' => $anotherStudent->id,
            'course_id' => $createdCourses[1]->id,
            'progress' => 100,
            'status' => 'completed',
        ]);

        // Seed some random enrollments for other students
        for ($i = 1; $i <= 15; $i++) {
            $randUser = User::where('email', 'student' . $i . '@example.com')->first();
            if ($randUser) {
                // Enroll in 1 or 2 random courses
                $cIds = array_rand($createdCourses, 2);
                Enrollment::create([
                    'user_id' => $randUser->id,
                    'course_id' => $createdCourses[$cIds[0]]->id,
                    'progress' => rand(10, 100),
                    'status' => 'active',
                ]);
            }
        }

        // 4. Create Quizzes and Questions
        // Quiz 1: Prompt Engineering
        $quiz1 = Quiz::create([
            'course_id' => $createdCourses[0]->id,
            'title' => 'LLM & System Prompt Essentials',
            'description' => 'Test your understanding of temperature, system instructions, and multi-turn prompt structures.',
            'passing_score' => 70,
        ]);

        Question::create([
            'quiz_id' => $quiz1->id,
            'question_text' => 'Which parameter controls the randomness of an LLM response?',
            'option_a' => 'Max Tokens',
            'option_b' => 'Temperature',
            'option_c' => 'Top-P',
            'option_d' => 'Frequency Penalty',
            'correct_option' => 'B',
        ]);

        Question::create([
            'quiz_id' => $quiz1->id,
            'question_text' => 'What is the primary purpose of a System Prompt?',
            'option_a' => 'To define the model\'s behavior, persona, and rules.',
            'option_b' => 'To feed dynamic parameters to the API.',
            'option_c' => 'To compress context length and token count.',
            'option_d' => 'To query vector databases for semantic search.',
            'correct_option' => 'A',
        ]);

        Question::create([
            'quiz_id' => $quiz1->id,
            'question_text' => 'In prompt engineering, what does "Few-Shot Prompting" refer to?',
            'option_a' => 'Running multiple API calls concurrently.',
            'option_b' => 'Providing a single short sentence prompt.',
            'option_c' => 'Providing examples of input-output pairs in the prompt.',
            'option_d' => 'Asking the model to think step-by-step.',
            'correct_option' => 'C',
        ]);

        Question::create([
            'quiz_id' => $quiz1->id,
            'question_text' => 'What happens if you set the LLM\'s Temperature to 0?',
            'option_a' => 'The model becomes highly creative and erratic.',
            'option_b' => 'The model raises a division-by-zero exception.',
            'option_c' => 'The model becomes deterministic, picking the most probable token.',
            'option_d' => 'The output length is constrained to 0 tokens.',
            'correct_option' => 'C',
        ]);

        // Quiz 2: Laravel Blade
        $quiz2 = Quiz::create([
            'course_id' => $createdCourses[1]->id,
            'title' => 'Blade Templating Mastery',
            'description' => 'Assess your knowledge on layout slots, Laravel Breeze components, and component parameters.',
            'passing_score' => 75,
        ]);

        Question::create([
            'quiz_id' => $quiz2->id,
            'question_text' => 'How do you print variable output safely in a Blade view (escaping HTML)?',
            'option_a' => '{!! $variable !!}',
            'option_b' => '{{ $variable }}',
            'option_c' => '<% $variable %>',
            'option_d' => '@print($variable)',
            'correct_option' => 'B',
        ]);

        Question::create([
            'quiz_id' => $quiz2->id,
            'question_text' => 'Which directive is used to render child templates into a layout slot?',
            'option_a' => '@extends',
            'option_b' => '@include',
            'option_c' => '@yield or $slot',
            'option_d' => '@push',
            'correct_option' => 'C',
        ]);

        Question::create([
            'quiz_id' => $quiz2->id,
            'question_text' => 'How can you pass a PHP array directly to a class-based Blade component property?',
            'option_a' => 'attributes="array"',
            'option_b' => ':attributes="$array"',
            'option_c' => 'Using the ":" prefix (e.g. :items="$myArray")',
            'option_d' => '@pass($array)',
            'correct_option' => 'C',
        ]);

        // Quiz 3: Data Visualization
        $quiz3 = Quiz::create([
            'course_id' => $createdCourses[2]->id,
            'title' => 'Data Viz & Analytics Quiz',
            'description' => 'Covering raw dataset transformation, JSON feeds, and ApexCharts initialization.',
            'passing_score' => 70,
        ]);

        Question::create([
            'quiz_id' => $quiz3->id,
            'question_text' => 'Which chart type is best suited for showing trends over time?',
            'option_a' => 'Pie Chart',
            'option_b' => 'Bar Chart',
            'option_c' => 'Line or Area Chart',
            'option_d' => 'Donut Chart',
            'correct_option' => 'C',
        ]);

        Question::create([
            'quiz_id' => $quiz3->id,
            'question_text' => 'How do you feed data to ApexCharts dynamically in a browser?',
            'option_a' => 'By writing raw SQL in the javascript config.',
            'option_b' => 'By passing a JSON array to the series parameter in options.',
            'option_c' => 'By loading an excel file directly into the script.',
            'option_d' => 'By embedding PHP echo inside HTML tags.',
            'correct_option' => 'B',
        ]);

        // 5. Create Quiz Attempts
        // Alex passed Data Viz quiz
        QuizAttempt::create([
            'user_id' => $student->id,
            'quiz_id' => $quiz3->id,
            'score' => 100,
            'passed' => true,
        ]);

        // Alex failed then passed Prompt Engineering quiz
        QuizAttempt::create([
            'user_id' => $student->id,
            'quiz_id' => $quiz1->id,
            'score' => 50,
            'passed' => false,
        ]);

        QuizAttempt::create([
            'user_id' => $student->id,
            'quiz_id' => $quiz1->id,
            'score' => 80,
            'passed' => true,
        ]);

        // 6. Create Chat Messages (AI Assistant)
        ChatMessage::create([
            'user_id' => $student->id,
            'message' => 'Explain the core idea of Prompt Engineering in one sentence.',
            'response' => 'Prompt Engineering is the practice of crafting precise, contextual inputs to guide LLMs into generating accurate, useful, and structured outputs.',
        ]);

        ChatMessage::create([
            'user_id' => $student->id,
            'message' => 'What is the difference between @extends and @include in Laravel Blade?',
            'response' => '`@extends` is used to inherit a master layout (defining the global scaffolding structure where page slots will inject content), while `@include` simply imports a partial view template (like a footer, card, or banner) directly inside the current view.',
        ]);

        // 7. Create Activity Logs
        ActivityLog::create([
            'user_id' => $student->id,
            'activity_type' => 'course_started',
            'description' => 'Started the course: Advanced Prompt Engineering & LLMs.',
        ]);

        ActivityLog::create([
            'user_id' => $student->id,
            'activity_type' => 'quiz_completion',
            'description' => 'Passed the quiz: LLM & System Prompt Essentials with 80%.',
        ]);

        ActivityLog::create([
            'user_id' => $student->id,
            'activity_type' => 'certificate',
            'description' => 'Earned a Completion Certificate in Data Visualization with Python & ApexCharts.',
        ]);

        ActivityLog::create([
            'user_id' => $student->id,
            'activity_type' => 'ai_chat',
            'description' => 'Consulted EduMind AI on "Laravel Blade Components".',
        ]);

        ActivityLog::create([
            'user_id' => $student->id,
            'activity_type' => 'enrollment',
            'description' => 'Enrolled in Mastering Laravel & Blade Component Design.',
        ]);
    }
}
