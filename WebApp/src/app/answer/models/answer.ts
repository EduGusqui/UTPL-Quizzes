import { Question } from '../../question/models/question';

export class Answer {
	constructor(
		public Id?: number,
		public Description?: string,
		public Correct?: boolean,
		public Status?: string,
		public Question?: Question
	) {}
}