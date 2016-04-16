class AddDayPartInfoToOffer < ActiveRecord::Migration
  def change
    dayParts = %w(morning daytime eveningNews localPrimeTime nationalPrimeTime lateNews lateNight overnights)
    dayParts.each do |daypart|
      %w(Audience Rate Hours WeeklyRate).each do |item|
        name = daypart + item
        add_column :offers, name, :string
      end
    end
  end
end
