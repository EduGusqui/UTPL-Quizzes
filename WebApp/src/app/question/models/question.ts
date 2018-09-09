import { Quiz } from '../../quiz/models/quiz';
import { Answer } from '../../answer/models/answer';

export class Question {
	constructor(
		public Id?: number,
		public Description?: string,
		public Status?: string,
		public Quiz?: Quiz,
		public Answers?: Answer[],
		public AnswerSelected?: number
	) {}
}