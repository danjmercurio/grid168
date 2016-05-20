# == Schema Information
#
# Table name: offers
#
#  id                :integer(4)      not null, primary key
#  outlet_id         :integer(4)
#  yearly_offer      :float           default(0.0), not null
#  monthly_offer     :float           default(0.0), not null
#  weekly_offer      :float           default(0.0), not null
#  hourly_rate       :float           default(0.0), not null
#  total_hours       :float           default(0.0), not null
#  created_at        :datetime
#  updated_at        :datetime
#  dollar_amount     :float           default(0.0), not null
#  half_hour_clicked :text
#  user_id           :integer(4)
#

class Offer < ActiveRecord::Base
	belongs_to :outlet
	has_and_belongs_to_many :programmers
	belongs_to :user
	has_many :notes, :dependent => :destroy

  attr_accessible :programmer_ids, :yearly_offer, :monthly_offer, :outlet_id, :weekly_hours,
									:monthly_hours, :yearly_hours, :weekly_offer, :hourly_rate, :total_hours,
									:dollar_amount, :user_id, :time_cells, :available_date, :grNotes, :dpNotes,
									:mvpdSubscriberRate, :mvpdOtaSubRate, :halfHourRate, :morningAudience,
									:morningRate, :morningHours, :morningWeeklyRate, :daytimeAudience, :daytimeRate,
									:daytimeHours, :daytimeWeeklyRate, :eveningNewsAudience, :eveningNewsRate,
									:eveningNewsHours, :eveningNewsWeeklyRate, :localPrimeTimeAudience, :localPrimeTimeRate,
									:localPrimeTimeHours, :localPrimeTimeWeeklyRate, :nationalPrimeTimeAudience,
									:nationalPrimeTimeRate, :nationalPrimeTimeHours, :nationalPrimeTimeWeeklyRate,
									:lateNewsAudience, :lateNewsRate, :lateNewsHours, :lateNewsWeeklyRate, :lateNightAudience,
									:lateNightRate, :lateNightHours, :lateNightWeeklyRate, :overnightsAudience, :overnightsRate,
									:overnightsHours, :overnightsWeeklyRate, :runningAudienceTotal, :runningHoursTotal, :runningWeeklyRateTotal, :disclaimer, :internalNotes, :status

  validates :dollar_amount, :presence => true,
								numericality: { greater_than: 0 }

	validates :total_hours, numericality: {
      greater_than: 0,
      message: 'You must select half-hour and calculate.'
								}

	validates :programmer_ids, :hourly_rate, :monthly_offer, :weekly_offer, :yearly_offer,
						:dollar_amount, :total_hours, :user_id, presence: true

	# list all programmers's name of this offer and parse to array
	def list_programmer_names
		self.programmers.select(:name).map{|x| x.name}
	end
end
